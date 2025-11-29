// ======== CORE LOGIC ========
const letters = 'ABCDEFGHIJKL'.split('');
let raw = [];
let pots = {1: [], 2: [], 3: [], 4: []};
let groups = {}; // {A: [slot1..4]}
let currentPot = 1;

// ======== DOM REFS ========
const potsContainer = document.getElementById('pots');
const groupsEl = document.querySelector('.groups-section');

// ======== INIT GROUPS ========
function initEmptyGroups() {
    letters.forEach(L => {
        if (!groups[L]) groups[L] = [null, null, null, null];
    });

    groupsEl.innerHTML = '';
    const wrapperSize = 3;

    for (let i = 0; i < letters.length; i += wrapperSize) {
        const wrapper = document.createElement('div');
        const chunk = letters.slice(i, i + wrapperSize);

        chunk.forEach(L => {
            const div = document.createElement('div');
            div.className = 'group-items';
            div.id = `group${L.toLowerCase()}`;
            div.innerHTML = `
                <h4>Group ${L}</h4>
                <ul class='slots' data-group='${L}'></ul>
            `;
            wrapper.appendChild(div);
        });

        groupsEl.appendChild(wrapper);
    }
}

// ======== LOAD DATA ========
function loadData(data) {
    raw = data.slice();
    raw.sort((a, b) => Number(a.seed) - Number(b.seed));

    // Reset pots and groups
    pots = {1: [], 2: [], 3: [], 4: []};
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
        // Assign pot based on seed
        const potNum = Math.floor((Number(t.seed) - 1) / 12) + 1;
        if (potNum >= 1 && potNum <= 4) pots[potNum].push(t);

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

    initEmptyGroups();
    currentPot = 1;
    renderPots();
    renderGroups();
}

// ======== RENDER GROUPS ========
function renderGroups() {
    document.querySelectorAll('.slots').forEach(s => {
        const L = s.dataset.group;
        s.innerHTML = '';

        groups[L].forEach((t, i) => {
            const slot = document.createElement('li');
            slot.className = 'slot';
            slot.dataset.group = L;
            slot.dataset.slot = i + 1;

            if (t) { // Team assigned
                slot.classList.add("team-drawn");
                slot.textContent = t.national_team;

                slot.style.setProperty("--i", "#1A3374"); // default inner color
                switch (t.conf) {
                    case "uefa": slot.style.setProperty("--j","#EE3730"); break;
                    case "conmebol": slot.style.setProperty("--j","#7EB4E1"); break;
                    case "concacaf": slot.style.setProperty("--j","#D5BA81"); break;
                    case "afc": slot.style.setProperty("--j","#e47812ff"); break;
                    case "caf": slot.style.setProperty("--j","#F8E825"); break;
                    case "ofc": slot.style.setProperty("--j","#4BBC38"); break;
                    case "fifa": slot.style.setProperty("--j","#0045f5ff"); break;
                }
            } else { // Empty placeholder
                slot.textContent = `${L}${i+1}`;
            }

            s.appendChild(slot);
        });
    });
}

// ======== RENDER POTS ========
function renderPots() {
    potsContainer.innerHTML = '';

    for (let p = 1; p <= 4; p++) {
        const div = document.createElement('div');
        div.innerHTML = `
            <h3>Pot ${p}</h3>
            <ul id="pot${p}"></ul>
        `;
        potsContainer.appendChild(div);

        const list = div.querySelector(`#pot${p}`);

        pots[p].forEach(team => {
            const el = document.createElement('li');
            el.className = 'team';
            el.dataset.pot = p;
            el.dataset.conf = team.conf;
            el.dataset.id = team.id;

            const img = document.createElement("img");
            img.src = `https://flagcdn.com/${team.code}.svg`;
            img.alt = team.small_team || team.national_team;
            img.onerror = () => { img.src = `/img/fed/${team.conf}.svg`; };

            el.appendChild(img);
            el.appendChild(document.createTextNode(" " + team.national_team));
            list.appendChild(el);
        });
    }
}

// ======== INITIAL FETCH ========
fetch('api_wc.php')
    .then(r => r.json())
    .then(j => {
        loadData(j.data || j);
    })
    .catch(() => {
        initEmptyGroups();
        renderGroups();
        renderPots();
    });
