const emailElement = document.getElementById('email')
const messageElement = document.getElementById('message')

emailElement.addEventListener('change', updateMessage)

function updateMessage(event) {
    messageElement.innerHTML = ""
    if (emailElement.value.length === 0) return
    /* set hardcoded baseURL variable */
    //let baseURL = 'http://localhost:8080/'

    /* use regular expression to extract baseURL from document.URL
     * ref: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Regular_Expressions */
    const re = new RegExp('https?:\/\/[a-zA-Z\.\-_]+(:[0-9]+)?\/');
    let resultMatch = document.URL.match(re)
    let baseURL = resultMatch[0]

    let data = new FormData()
    data.append('email', emailElement.value)
    /* use baseURL variable to dynamically construct URL */
    fetch(`${baseURL}check_user.php`,{method:'post',body:data})
        .then((response) => {
            if (response.status === 200) {
                messageElement.innerHTML = "Welcome back!"
            }
        })
}