const projectsContainer = document.querySelector(".projects-container");
const searchInput = document.querySelector("#searchInput");
fetch("https://api.github.com/users/dariaelenacalugar/repos")
    .then(response =>{
        if(!response.ok){
            throw new Error("Eroare API");
        }
        return response.json();
    })
    .then(data => {
        const filteredRepos = data.filter(repo => repo.fork === false);
        filteredRepos.sort((a, b) =>
            new Date(b.updated_at) - new Date(a.updated_at)
        );
        displayProjects(filteredRepos);
        function displayProjects(repos) {
            projectsContainer.innerHTML = "";
            repos.forEach(repo => {
                const card = document.createElement("div");
                card.classList.add("project-card");
                card.innerHTML = `
                    <h3>${repo.name}</h3>
                    <p>
                        ${repo.description || "Fără descriere disponibilă"}
                    </p>
                    <p>
                        <strong>Limbaj:</strong> ${repo.language}
                    </p>
                    <p>
                        ${repo.stargazers_count}
                        | Forks: ${repo.forks_count}
                    </p>
                    <a href="${repo.html_url}" target="_blank">
                        Vezi proiect
                    </a>
                `;
                projectsContainer.appendChild(card);
            });
        }
        searchInput.addEventListener("input", () => {
            const searchValue = searchInput.value.toLowerCase();
            const searchedRepos = filteredRepos.filter(repo =>
                repo.name.toLowerCase().includes(searchValue)
            );
            displayProjects(searchedRepos);
        });
    })
    .catch(error=>{
        projectsContainer.innerHTML=`
        <p class="error-message">
            Sorry!Nu am putut încărca proiectele momentan.
        </p>
        `;
    });
    
    
