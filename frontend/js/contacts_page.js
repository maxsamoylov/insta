function setSubmitButtonStatus() {
    const button = document.getElementById('contacts_btn');
    const checkboxes = document.getElementsByClassName('checkbox');

    for (let checkbox of checkboxes) {
        if (checkbox.checked) {
            button.disabled = false;
            return;
        }
    }
    button.disabled = true;
}

function uncheckAll() {
    const checkboxes = document.getElementsByClassName('checkbox');

    for (let checkbox of checkboxes) {
        checkbox.checked = false;
    }
}

window.onload = () => {

    uncheckAll();
    setSubmitButtonStatus();

    document.getElementById('contacts_div').addEventListener('click', (e) => {
        if ('type' in e.target && e.target.type === 'checkbox') {
            setSubmitButtonStatus();
        }
    });

    const contactsForm = document.getElementById('contacts_form');
    contactsForm.onsubmit = (e) => {
        e.preventDefault();

        const submitBtn = document.getElementById('contacts_btn');
        submitBtn.disabled = true;

        fetch('backend/addContacts.php', {
            method: 'POST',
            body: new FormData(contactsForm)
        })
            .then(response => response.json())
            .then(result => {
                if (result.length > 0) {
                    document.getElementById('add_contact_error').textContent = result[0];
                    submitBtn.disabled = false;
                } else {
                    location.reload();
                }
            })
            .catch((e) => {
                document.getElementById('add_contact_error').textContent = e.message;
                submitBtn.disabled = false;
            });
    };
};
