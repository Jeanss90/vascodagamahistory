document.addEventListener("DOMContentLoaded", () => {
    fetch("api_wc_matches.php")
        .then(r => r.json())
        .then(matches => renderKnockout(matches))
        .catch(err => console.error(err));
});

const knockoutPositions = {
    R32: { 1: [74, 77], 2: [73, 75], 3: [83, 84], 4: [81, 82], 5: [76, 78], 6: [79, 80], 7: [86, 88], 8: [85, 87] },
    R16: { 1: [89, 90], 2: [93, 94], 3: [91, 92], 4: [95, 96] },
    QF:  { 1: [97, 98], 2: [99, 100] },
    SF:  { 1: [101, 102] },
    P34: { 1: [103] },
    F:   { 1: [104] }
};

function renderKnockout(matches) {

    Object.keys(knockoutPositions).forEach(round => {
        const roundId = round.toLowerCase();
        let slots;

        // Special case: P34 + F → final only
        if (round === "P34" || round === "F") {
            slots = document.querySelectorAll(`#final .${roundId}`);
        } else {
            slots = {
                path1: document.querySelectorAll(`.path1 .${roundId}`),
                path2: document.querySelectorAll(`.path2 .${roundId}`)
            };
        }

        // Flatten match numbers
        const matchList = Object.values(knockoutPositions[round]).flat();

        // Insert round title
        const roundTitle = document.createElement("h3");
        const names = { R32:"Round of 32", R16:"Round of 16", QF:"Quarter Finals", SF:"Semi Finals", P34:"Third Place", F:"Final" };
        roundTitle.textContent = names[round];

        if (round === "P34" || round === "F") {
            slots[0]?.parentElement.prepend(roundTitle);
        } else {
            slots.path1[0]?.parentElement.prepend(roundTitle.cloneNode(true));
            slots.path2[0]?.parentElement.prepend(roundTitle.cloneNode(true));
        }

        // Helper to fill a slot
        const fillSlot = (slot, matchNumber, matchData) => {
            slot.textContent = `M${matchNumber}`; // Outer span shows match number
            if (matchData) {
                const inner = document.createElement("span");
                inner.classList.add("matches");
                const br = document.createElement("br");
                inner.appendChild(br);
                const textNode = document.createTextNode(`${matchData.casa} vs ${matchData.fora}`);
                inner.appendChild(textNode);
                slot.appendChild(inner);
            }
        };

        // Split match list for paths
        if (round === "P34" || round === "F") {
            slots.forEach((slot, idx) => {
                const matchData = matches.find(m => m.grupo.toLowerCase() === `m${matchList[idx]}`);
                fillSlot(slot, matchList[idx], matchData);
            });
        } else {
            const half = Math.ceil(matchList.length / 2);
            const list1 = matchList.slice(0, half);
            const list2 = matchList.slice(half);

            slots.path1.forEach((slot, idx) => {
                const matchData = matches.find(m => m.grupo.toLowerCase() === `m${list1[idx]}`);
                fillSlot(slot, list1[idx], matchData);
            });

            slots.path2.forEach((slot, idx) => {
                const matchData = matches.find(m => m.grupo.toLowerCase() === `m${list2[idx]}`);
                fillSlot(slot, list2[idx], matchData);
            });
        }

    });
}
