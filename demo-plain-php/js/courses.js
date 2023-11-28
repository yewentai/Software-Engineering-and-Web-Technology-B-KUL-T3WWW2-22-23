const bookItems = document.getElementsByClassName('bookItem')
const infoItem = document.getElementById('info-text')
for (const book of bookItems) {
    book.addEventListener('click', updateReference)
}

function updateReference(event) {
    let isbn = event.target.dataset.isbn
    fetch(`https://openlibrary.org/isbn/${isbn}.json`)
        .then((response) => {
            if (response.ok) return response.json()
            else throw new Error('not found')
        })
        .then((result) => {
            console.log(result)
            infoItem.innerHTML = `published on ${result.publish_date} (${result.number_of_pages} pages)`
        })
        .catch(error => infoItem.innerHTML = "No extra info found")
}