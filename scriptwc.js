const potLists = {
    1: document.querySelector("#pot1"),
    2: document.querySelector("#pot2"),
    3: document.querySelector("#pot3"),
    4: document.querySelector("#pot4")
};

fetch("api_wc.php")
    .then(res => res.json()) // parse JSON from response
    .then(draw => {

        draw.data
            .sort((a, b) => a.seed - b.seed)
            .forEach(team => {
                const li = document.createElement("li");
                const img = document.createElement("img");
                img.src = `https://flagcdn.com/${team.code}.svg`;
                img.alt = team.small_team || team.national_team;
                img.onerror = () => { img.src = `/img/fed/${team.conf}.svg`; };
                li.appendChild(img);
                li.appendChild(document.createTextNode(team.national_team));
                li.dataset.conf = team.conf || "";

                if (team.seed >= 1 && team.seed <= 12) potLists[1].appendChild(li);
                else if (team.seed >= 13 && team.seed <= 24) potLists[2].appendChild(li);
                else if (team.seed >= 25 && team.seed <= 36) potLists[3].appendChild(li);
                else if (team.seed >= 37 && team.seed <= 48) potLists[4].appendChild(li);
            
                /*wait for draw to finish before adding this bit
                otherwise code will brask as table_position is still
                null for some
                */
                /*
                const id = document.getElementById(`${team.table_position}`);
                id.classList.add("team-drawn");
                id.style.setProperty("--i", "#1A3374");
                switch (team.conf) {
                    case "uefa":
                        id.style.setProperty("--j", "#EE3730");
                        break;
                    case "conmebol":
                        id.style.setProperty("--j", "#7EB4E1");
                        break;
                    case "concacaf":
                        id.style.setProperty("--j", "#D5BA81");
                        break;
                    case "afc":
                        id.style.setProperty("--j", "#e47812ff");
                        break;
                    case "caf":
                        id.style.setProperty("--j", "#F8E825");
                        break;
                    case "ofc":
                        id.style.setProperty("--j", "#4BBC38");
                        break;
                    case "fifa":
                        id.style.setProperty("--j", "#7e9ae2ff");
                        break;
                }
                id.textContent = team.national_team;
                */
            });
    });
