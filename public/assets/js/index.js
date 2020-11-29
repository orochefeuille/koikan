const listGroupItems = document.getElementsByClassName("list-group-item");
function manageActiveClass() {
    for (let listGroupItem of listGroupItems) {
        listGroupItem.addEventListener('click', function (event) {
            if( event.target.tagName.toLowerCase() === 'a' || event.target.tagName.toLowerCase() === 'i') {
                return;
            }
            let plusMinus = this.querySelector('.plus-minus');
            this.nextElementSibling.style.height === "0px"
                ? this.nextElementSibling.style.height = this.nextElementSibling.scrollHeight + "px"
                : this.nextElementSibling.style.height = "0px"
            plusMinus.innerHTML === '<i class="fas fa-plus-square"></i>' ? plusMinus.innerHTML = '<i class="fas fa-minus-square"></i>' : plusMinus.innerHTML = '<i class="fas fa-plus-square"></i>';
        })
    }
}

const listTab = document.querySelectorAll("#list-tab");
const statusText = document.querySelectorAll("#js-status-text");
const statusIcon = document.querySelectorAll("#js-status-icon");

function giveStatusColor(statusText, statusIcon) {
    for(let i=0; i < statusText.length; i++) {
        if(statusText[i].textContent === 'todo') {
            statusText[i].classList.remove("text-orange-dark");
            statusText[i].classList.add("text-green");
            statusIcon[i].classList.remove("text-orange-dark");
            statusIcon[i].classList.add("text-green");
        }
        else if(statusText[i].textContent === 'in progress') {
            statusText[i].classList.remove("text-green");
            statusText[i].classList.add("text-orange-light");
            statusIcon[i].classList.remove("text-green");
            statusIcon[i].classList.add("text-orange-light");
        }
        else if(statusText[i].textContent === 'done'){
            statusText[i].classList.remove("text-orange-light");
            statusText[i].classList.add("text-orange-dark");
            statusIcon[i].classList.remove("text-orange-light");
            statusIcon[i].classList.add("text-orange-dark");
            listTab[i].classList.toggle("isDone");
        }
    }
    
}

const projectStatuses = document.getElementsByClassName("js-project-status");
function changeProjectStatus(statusText, statusIcon) {
    for (let projectStatus of projectStatuses) {
        projectStatus.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
       
            const thisStatusText = this.querySelector("#js-status-text");
            const thisStatusIcon = this.querySelector("#js-status-icon");
            const thisListTab = this.closest("#list-tab");
            axios.get(this.href)
                .then(function (response){
                    thisStatusText.textContent = response.data.statusText;
                    if(thisStatusText.textContent === 'todo') {
                        thisStatusText.classList.remove("text-orange-dark");
                        thisStatusText.classList.add("text-green");
                        thisStatusIcon.classList.remove("text-orange-dark");
                        thisStatusIcon.classList.add("text-green");
                        thisListTab.classList.remove("isDone");
                    }
                    else if(thisStatusText.textContent === 'in progress') {
                        thisStatusText.classList.remove("text-green");
                        thisStatusText.classList.add("text-orange-light");
                        thisStatusIcon.classList.remove("text-green");
                        thisStatusIcon.classList.add("text-orange-light");
                    }
                    else if(thisStatusText.textContent === 'done'){
                        thisStatusText.classList.remove("text-orange-light");
                        thisStatusText.classList.add("text-orange-dark");
                        thisStatusIcon.classList.remove("text-orange-light");
                        thisStatusIcon.classList.add("text-orange-dark");
                        thisListTab.classList.add("isDone");
                    }
                })
                .catch(function (error) {
                    if(error.response.status === 404) {
                        console.log('erreur 404');
                    }
                });
        })
    }
}

giveStatusColor(statusText, statusIcon);
manageActiveClass();
changeProjectStatus();
