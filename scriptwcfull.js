// ===============================
// CORE CONSTANTS
// ===============================
const letters = 'ABCDEFGHIJKL'.split('');
let rawTeams = [];
let groups = {};
let matches = [];       // Match API data
let allMatches = [];    // Used for stats calculations

// ===============================
// FORMAT DATE (EST/EDT → Local)
// ===============================
function formatMatchDate(str) {
    // Append EST/EDT summer offset for 2026 (UTC-4)
    const nyDate = new Date(str.replace(" ", "T") + "-04:00");

    return new Intl.DateTimeFormat(undefined, {
        weekday: "short",
        day: "2-digit",
        month: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        hour12: false
    }).format(nyDate).replace(/,/g, "");
}

// ===============================
// STATS FUNCTIONS (use allMatches)
// Only count if BOTH scores are NOT null
// ===============================

// Helper: is this match valid (played)?
function isPlayed(m) {
    return m.score_casa != null && m.score_fora != null;
}

function getPG(team) {
    if (!team) return 0;
    return allMatches.filter(m =>
        isPlayed(m) &&
        (m.casa === team || m.fora === team)
    ).length;
}

function getP(team) {
    if (!team) return 0;
    let pts = 0;

    allMatches.forEach(m => {
        if (!isPlayed(m)) return;

        if (m.casa === team) {
            if (m.score_casa > m.score_fora) pts += 3;
            else if (m.score_casa === m.score_fora) pts += 1;
        }

        if (m.fora === team) {
            if (m.score_fora > m.score_casa) pts += 3;
            else if (m.score_fora === m.score_casa) pts += 1;
        }
    });

    return pts;
}

function getW(team) {
    if (!team) return 0;
    return allMatches.filter(m =>
        isPlayed(m) &&
        (
            (m.casa === team && m.score_casa > m.score_fora) ||
            (m.fora === team && m.score_fora > m.score_casa)
        )
    ).length;
}

function getD(team) {
    if (!team) return 0;
    return allMatches.filter(m =>
        isPlayed(m) &&
        (m.casa === team || m.fora === team) &&
        m.score_casa === m.score_fora
    ).length;
}

function getL(team) {
    if (!team) return 0;
    return allMatches.filter(m =>
        isPlayed(m) &&
        (
            (m.casa === team && m.score_casa < m.score_fora) ||
            (m.fora === team && m.score_fora < m.score_casa)
        )
    ).length;
}

function getGF(team) {
    if (!team) return 0;
    let g = 0;

    allMatches.forEach(m => {
        if (!isPlayed(m)) return;

        if (m.casa === team) g += Number(m.score_casa);
        if (m.fora === team) g += Number(m.score_fora);
    });

    return g;
}

function getGA(team) {
    if (!team) return 0;
    let g = 0;

    allMatches.forEach(m => {
        if (!isPlayed(m)) return;

        if (m.casa === team) g += Number(m.score_fora);
        if (m.fora === team) g += Number(m.score_casa);
    });

    return g;
}

function getDiff(team) {
    return getGF(team) - getGA(team);
}

function getX(team) {
    return team ? `${team}` : "";
}

function getH2HMatches(teamA, teamB) {
    return allMatches.filter(m =>
        (m.casa === teamA && m.fora === teamB) ||
        (m.casa === teamB && m.fora === teamA)
    );
}

function getH2HStats(teamA, teamB) {
    const matches = getH2HMatches(teamA, teamB);

    let ptsA = 0, ptsB = 0;
    let gfA = 0, gfB = 0;
    let gaA = 0, gaB = 0;

    matches.forEach(m => {
        if (m.score_casa == null || m.score_fora == null) return;

        if (m.casa === teamA) {
            gfA += m.score_casa;
            gaA += m.score_fora;
            gfB += m.score_fora;
            gaB += m.score_casa;

            if (m.score_casa > m.score_fora) ptsA += 3;
            else if (m.score_casa < m.score_fora) ptsB += 3;
            else { ptsA += 1; ptsB += 1; }
        }

        if (m.casa === teamB) {
            gfB += m.score_casa;
            gaB += m.score_fora;
            gfA += m.score_fora;
            gaA += m.score_casa;

            if (m.score_casa > m.score_fora) ptsB += 3;
            else if (m.score_casa < m.score_fora) ptsA += 3;
            else { ptsA += 1; ptsB += 1; }
        }
    });

    return {
        ptsA, ptsB,
        diffA: gfA - gaA,
        diffB: gfB - gaB,
        gfA, gfB
    };
}


// ===============================
// SORT TABLE
// ===============================
function sortGroupTeams(groupArray) {
    return groupArray.slice().sort((a, b) => {
        const tA = a ? a.national_team : null;
        const tB = b ? b.national_team : null;

        if (!tA || !tB) return 0;

        // 1. Points
        const P_A = getP(tA);
        const P_B = getP(tB);
        if (P_B !== P_A) return P_B - P_A;

        // 2. Wins
        const W_A = getW(tA);
        const W_B = getW(tB);
        if (W_B !== W_A) return W_B - W_A;

        // 3. Goal Difference
        const D_A = getDiff(tA);
        const D_B = getDiff(tB);
        if (D_B !== D_A) return D_B - D_A;

        // 4. Goals For
        const GF_A = getGF(tA);
        const GF_B = getGF(tB);
        if (GF_B !== GF_A) return GF_B - GF_A;

        // --------------------
        // 5. Head-to-Head
        // --------------------
        const h2h = getH2HStats(tA, tB);

        if (h2h.ptsB !== h2h.ptsA) return h2h.ptsB - h2h.ptsA;       // H2H points  
        if (h2h.diffB !== h2h.diffA) return h2h.diffB - h2h.diffA;   // H2H diff
        if (h2h.gfB !== h2h.gfA) return h2h.gfB - h2h.gfA;           // H2H goals

        // --------------------
        // 6. Custom sorting: column "X"
        // --------------------
        const X_A = a?.X ? parseInt(a.X) : 0;
        const X_B = b?.X ? parseInt(b.X) : 0;

        if (X_B !== X_A) return X_B - X_A;

        // --------------------
        // 7. Final fallback
        // --------------------
        return tA.localeCompare(tB);
    });
}

// ===============================
// LOAD TEAM DATA → groups[]
// ===============================
function loadTeams(data) {
    rawTeams = data.slice();
    rawTeams.sort((a, b) => Number(a.seed) - Number(b.seed));

    groups = {};
    letters.forEach(L => groups[L] = [null, null, null, null]);

    const tablePositions = {
        A: [1, 25, 13, 37],  B: [2, 38, 26, 14],
        C: [3, 15, 39, 27],  D: [4, 28, 16, 40],
        E: [5, 41, 29, 17],  F: [6, 18, 42, 30],
        G: [7, 31, 19, 43],  H: [8, 44, 32, 20],
        I: [9, 21, 45, 33],  J: [10, 34, 22, 46],
        K: [11, 47, 35, 23], L: [12, 24, 48, 36]
    };

    rawTeams.forEach(t => {
        letters.forEach(L => {
            tablePositions[L].forEach((pos, i) => {
                if (pos === Number(t.table_position)) {
                    groups[L][i] = t;
                }
            });
        });
    });
}

// ===============================
// RENDER GROUP TABLES
// ===============================
function renderGroups() {
    letters.forEach(L => {
        const tbody = document.querySelector(`#group${L.toLowerCase()} table tbody`);
        if (!tbody) return;

        tbody.innerHTML = "";

        const sortedTeams = sortGroupTeams(groups[L]);

        // --- TEAM ROWS ---
        sortedTeams.forEach((team, index) => {
            const t = team ? team.national_team : `${L}${index + 1}`;
            const row = document.createElement("tr");

            row.innerHTML = `
                <td data-hide="true">${index + 1}</td>
                <td>${t}</td>
                <td>${getPG(t)}</td>
                <td data-hide="true">${getP(t)}</td>
                <td>${getW(t)}</td>
                <td>${getD(t)}</td>
                <td>${getL(t)}</td>
                <td>${getGF(t)}</td>
                <td>${getGA(t)}</td>
                <td>${getDiff(t)}</td>
                <td style="visibility:hidden; display:none;">${getX(t)}</td>
            `;
            tbody.appendChild(row);
        });

        // --- MATCHES ---
        const groupMatches = matches.filter(m => m.grupo.toUpperCase() === L);

        if (groupMatches.length > 0) {
            const sep = document.createElement("tr");
            sep.innerHTML = `
                <td colspan="10" style="text-align:center;">
                    <h4 style="padding-bottom:0;">MATCHES</h4>
                </td>
            `;
            tbody.appendChild(sep);
        }

        groupMatches.forEach(m => {
            const r = document.createElement("tr");
            r.innerHTML = `
                <td colspan="2">${formatMatchDate(m.horario)}</td>
                <td colspan="2">${m.casa}</td>
                <td>${m.score_casa != null ? m.score_casa : ""} x ${m.score_fora != null ? m.score_fora : ""}</td>
                <td colspan="2">${m.fora}</td>
                <td data-hide="true" colspan="3">${m.estadio}</td>
            `;
            tbody.appendChild(r);
        });
    });
}

// ===============================
// LOAD BOTH APIs FIRST
// ===============================
Promise.all([
    fetch("api_wc.php").then(r => r.json()),
    fetch("api_wc_matches.php").then(r => r.json())
]).then(([teamData, matchData]) => {

    // Normalize data format
    const teams = teamData.data || teamData;
    const matchList = matchData.data || matchData;

    // Store match data globally
    matches = matchList;
    allMatches = matchList;

    // Build groups
    loadTeams(teams);

    // Render everything once
    renderGroups();

}).catch(err => {
    console.error("Error loading data:", err);
});
