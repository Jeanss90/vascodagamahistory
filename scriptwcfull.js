document.addEventListener("DOMContentLoaded", () => {
    populateTables();
});

function populateTables() {
    const letters = "ABCDEFGHIJKL".split("");

    letters.forEach(letter => {
        const groupId = `group${letter.toLowerCase()}`;
        const groupTable = document.querySelector(`#${groupId} table tbody`);

        if (!groupTable) return;

        groupTable.innerHTML = ""; // Clear existing rows

        for (let i = 1; i <= 4; i++) {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${i}</td>
                <td>${letter}${i}</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td style="visibility: hidden; display: none;"></td>
            `;

            groupTable.appendChild(row);
        }
    });
}

// ======== CORE LOGIC ========
const letters = 'ABCDEFGHIJKL'.split('');
let raw = [];
let groups = {}; // {A: [slot1..4]}

// ======== DOM REFS ========
const groupsEl = document.querySelector('.groups-section');

// ======== LOAD DATA ========
function loadData(data) {
    raw = data.slice();
    raw.sort((a, b) => Number(a.seed) - Number(b.seed));

    // Reset pots and groups
    groups = {};
    letters.forEach(L => groups[L] = [null, null, null, null]);

    // Predefined group allocation from table positions
    const tablePositions = {
        A: [1, 25, 13, 37],
        B: [2, 38, 26, 14],
        C: [3, 15, 39, 27],
        D: [4, 28, 16, 40],
        E: [5, 41, 29, 17],
        F: [6, 18, 42, 30],
        G: [7, 31, 19, 43],
        H: [8, 44, 32, 20],
        I: [9, 21, 45, 33],
        J: [10, 34, 22, 46],
        K: [11, 47, 35, 23],
        L: [12, 24, 48, 36]
    };

    // Assign teams to pots and groups
    raw.forEach(t => {

        // Assign to group based strictly on table_position
        letters.forEach(L => {
            const slots = tablePositions[L];
            for (let i = 0; i < 4; i++) {
                if (slots[i] === Number(t.table_position)) {
                    groups[L][i] = t;
                }
            }
        });
    });
    renderGroups();
}

// ======== RENDER GROUPS ========
function renderGroups() {
    letters.forEach(L => {
        const groupId = `group${L.toLowerCase()}`;
        const tbody = document.querySelector(`#${groupId} table tbody`);

        if (!tbody) return;

        // Clear table
        tbody.innerHTML = "";

        // 4 slots: A1, A2, A3, A4
        groups[L].forEach((team, index) => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${team ? team.national_team : `${L}${index + 1}`}</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td style="visibility: hidden; display: none;"></td>
            `;

            tbody.appendChild(row);
        });
    });
}


// ======== INITIAL FETCH ========
fetch('api_wc.php')
    .then(r => r.json())
    .then(j => {
        loadData(j.data || j);
    })
    .catch(() => {
        renderGroups();
    });

