const btnImg = document.getElementById("btnImg")
const modal = document.querySelector("dialog")
const btnCloseModal = document.getElementById("btnCloseModal")
const inputSenhaModal = document.getElementById("inputSenhaModal")

btnImg.onclick = function () {
    modal.showModal()
} 

btnCloseModal.onclick = function () {
    modal.close()
}



