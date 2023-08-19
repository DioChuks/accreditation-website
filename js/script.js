const updateButton = document.getElementById("updateDetails");
const modal = document.getElementById("myModal");
const fileInput = modal.querySelector("input[type=file]");
const confirmBtn = modal.querySelector("#confirmBtn");
var span = document.getElementsByClassName("close")[0];

const addWorkButton = document.getElementById("workProfile");
const modalY = document.getElementById("myModal2");
const textInput = modalY.querySelector("#workLink");
const checkBtn = modalY.querySelector("#confirmBtn");
var x = document.getElementsByClassName("close")[1];
const err = modalY.querySelector("link-error-msg");

const textarea = document.querySelector('textarea');

function pregMatch(input) {
	var regExp = /^[a-zA-Z ]*$/;

	if (regExp.test(input)) {
		return true;
	} else {
		return false
	}
}

textarea.addEventListener('click', () => {
const element = document.querySelector('.extra_profile_hidden');
element.style.display = 'flex';
});


// "Update details" button opens the <dialog> modally
updateButton.addEventListener("click", () => {
modal.style.display = "inline-flex";
});
span.onclick = function() {
modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}
let c = 2;
confirmBtn.addEventListener("click", (e) => {
e.preventDefault();
// Create new elements
const newCertificateTitle = document.createElement("input");
newCertificateTitle.className = "certificate_title";
newCertificateTitle.type = "text";
newCertificateTitle.placeholder = "Title of Certificate";
newCertificateTitle.name = `certificate_title${c}`;

const newLabel = document.createElement("label");
newLabel.htmlFor = "uploadFile";
newLabel.innerHTML = '<img src="Iconly/Bulk/Plus.svg" alt="plus-svg">Add Certificate';

const newUploadFile = document.createElement("input");
newUploadFile.type = "file";
newUploadFile.name = `certificate_file${c}`;
newUploadFile.className = "uploadFile";
newUploadFile.style.visibility = "hidden";

// Append new elements to the dialog
fileInput.parentNode.insertBefore(newUploadFile, fileInput.nextSibling);
fileInput.parentNode.insertBefore(newLabel, fileInput.nextSibling);
fileInput.parentNode.insertBefore(newCertificateTitle, fileInput.nextSibling);

// Clear the inputs
newCertificateTitle.value = "";
newUploadFile.value = "";
c++;
});

//for the second modal
addWorkButton.addEventListener("click", () => {
    modalY.style.display = "inline-flex";
});
x.onclick = function() {
    modalY.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modalY) {
    modalY.style.display = "none";
    }
}
let counter = 2;
checkBtn.addEventListener("click", (e) => {
    e.preventDefault();
    // Create new elements
    const newWorkTitle = document.createElement("input");
    newWorkTitle.className = "work-title";
    newWorkTitle.id = "workTitle";
    newWorkTitle.type = "text";
    newWorkTitle.placeholder = "Title of Work";
    newWorkTitle.name = `work_title${counter}`;

    const newWorkDescription = document.createElement("input");
    newWorkDescription.className = "work-title";
    newWorkDescription.id = "workDesc";
    newWorkDescription.type = "text";
    newWorkDescription.placeholder = "Description";
    newWorkDescription.name = `work_desc${counter}`;

    const newWorkLink = document.createElement("input");
    newWorkLink.className = "work-title";
    newWorkLink.id = "workLink";
    newWorkLink.type = "text";
    newWorkLink.placeholder = "Link to your work";
    newWorkLink.name = `work_link${counter}`;

    // Append new elements to the dialog
    textInput.parentNode.insertBefore(newWorkLink, textInput.nextSibling);
    textInput.parentNode.insertBefore(newWorkDescription, textInput.nextSibling);
    textInput.parentNode.insertBefore(newWorkTitle, textInput.nextSibling);

    // Clear the inputs
    newWorkTitle.value = "";
    newWorkDescription.value = "";
    newWorkLink.value = "";
    counter++;
});

const joinBtn = document.getElementById('accrBtn');

joinBtn.addEventListener("click", (e) => {
    e.preventDefault();
    console.log('button clicked');
    
    // Create a new FormData object for the request
    var formData = new FormData(document.getElementById('joinForm'));
    
    $.ajax({
        url: "./php/check_accreditation.php",
        type: "POST",
        data: formData,
        processData: false, // Important for FormData
        contentType: false, // Important for FormData
        success: function (response) {
            if (response.length > 0) {
                alert(response);
                setTimeout(() => {
                    // Clear the form data
                    formData = new FormData();
                    window.location.href = '?schools';
                }, 1500);
                return;
            } else {
                console.log(response);
            }
        },
        error: function (xhr, status, error) {
            console.log("Error: " + error);
        },
    });
});
