const authorElement = document.getElementById('author')
const feedbackElement = document.getElementById('feedback')
const submitElement = document.getElementById('submit')

submitElement.disabled = true
authorElement.addEventListener("keyup", activateSubmit)
feedbackElement.addEventListener("keyup",activateSubmit)

function activateSubmit() {
    submitElement.disabled = (authorElement.value.length === 0) || (feedbackElement.value.length === 0)
}