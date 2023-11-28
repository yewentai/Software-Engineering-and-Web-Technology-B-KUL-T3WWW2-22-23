document.addEventListener('DOMContentLoaded', () => {
    const bookInfos = document.querySelectorAll('.book_info');

    bookInfos.forEach(bookInfo => {
        const isbn = bookInfo.dataset.isbn;

        fetch(`https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}`)
            .then(response => response.json())
            .then(data => {
                const bookData = data.items[0].volumeInfo;

                const coverImage = bookInfo.querySelector('.book_photo');
                const bookTitle = bookInfo.querySelector('.book_title');
                const bookAuthor = bookInfo.querySelector('.book_author');

                // Set the cover image
                if (bookData.imageLinks && bookData.imageLinks.thumbnail) {
                    coverImage.src = bookData.imageLinks.thumbnail;
                    coverImage.alt = `Cover image for the book ${bookData.title}`;
                }

                // Set the title
                if (bookTitle) {
                    bookTitle.textContent = bookData.title;
                }

                // Set the author
                if (bookAuthor) {
                    bookAuthor.textContent = 'By ' + bookData.authors.join(', ');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});

// Function to toggle the display of the edit form
function toggleEdit(field) {
    const fieldValueElement = document.getElementById(field);
    const editForm = document.getElementById(`edit_form_${field}`);

    // Toggle the visibility of the field value and edit form
    fieldValueElement.style.display = fieldValueElement.style.display === 'none' ? 'inline' : 'none';
    editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
}

// Function to handle the form submission for updating the display name
document.getElementById('edit_form_name').addEventListener('submit', function(event) {
    event.preventDefault();

    const displayNameInput = document.getElementById('displayNameInput');
    const nameSubmitButton = document.getElementById('name_submit');

    const newName = displayNameInput.value;

    // Make an AJAX request to update the display name
    fetch('/user/update/displayname', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            displayName: newName,
        }),
    })
.then(response => response.json())
        .then(data => {
            // Handle the response
            console.log(data.message); // You can customize this to display a success message to the user

            // Update the display name on the page
            const nameElement = document.getElementById('name');
            nameElement.textContent = newName;

            // Toggle the visibility of the field value and edit form
            toggleEdit('name');
        })
        .catch(error => {
            console.error('Error:', error); // You can customize this to display an error message to the user
        });
});

// Function to handle the form submission for updating the gender
document.getElementById('edit_form_gender').addEventListener('submit', function(event) {
    event.preventDefault();

    const genderSubmitButton = document.getElementById('gender_submit');

    // Get the selected gender from the form
    const genderInput = document.querySelector('input[name="gender"]:checked');
    const newGender = genderInput.value;

    // Make an AJAX request to update the gender
    fetch('/user/update/gender', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            gender: newGender,
        }),
    })
.then(response => response.json())
        .then(data => {
            // Handle the response
            console.log(data.message); // You can customize this to display a success message to the user

            // Update the gender on the page
            const genderElement = document.getElementById('gender');
            genderElement.textContent = newGender;

            // Toggle the visibility of the field value and edit form
            toggleEdit('gender');
        })
        .catch(error => {
            console.error('Error:', error); // You can customize this to display an error message to the user
        });
});
