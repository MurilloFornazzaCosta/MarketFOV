const btnImg = document.getElementById("btnImg")
const modal = document.querySelector("dialog")
const btnCloseModal = document.getElementById("btnCloseModal")

btnImg.onclick = function () {
    modal.showModal()
} 

btnCloseModal.onclick = function () {
    modal.close()
}

