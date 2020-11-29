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
manageActiveClass();