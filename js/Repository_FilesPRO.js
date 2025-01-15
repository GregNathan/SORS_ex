// Head buttons

// Home buttons
function redirectToHome1() {
    window.location.href = "home_menu1.php"; 
}

function redirectToHome2() {
    window.location.href = "home_menu2.html"; 
}

function redirectToHome3() {
    window.location.href = "home_menu3.html"; 
}

// Upload buttons
function redirectToUp1() {
    window.location.href = "Upload_Files1.html"; 
}

function redirectToUp2() {
    window.location.href = "Upload_Files2.html"; 
}

function redirectToUp3() {
    window.location.href = "Upload_Files3.html"; 
}

// Approve buttons
function redirectToApp1() {
    window.location.href = "Approve_Files1.html"; 
}

function redirectToApp3() {
    window.location.href = "Approve_Files3.html"; 
}

// Testing

const pp = jsDictionary;
console.log(pp);

// Testing Stop

// Body (Work on progress)
// const directory = {
//     "Folder1": [
//         { fileName: "File1", type: "file" },
//         { fileName: "File2", type: "file" },
//         { fileName: "Subfolder1", type: "folder", contents: [
//             { fileName: "File3", type: "file" },
//             { fileName: "File4", type: "file" },
//             { fileName: "File5", type: "file" },
//             { fileName: "Subfolder2", type: "folder", contents: [
//                 { fileName: "File6", type: "file" },
//                 { fileName: "File7", type: "file" },
//                 { fileName: "Subfolder4", type: "folder", contents: [
//                     { fileName: "File6", type: "file" },
//                     { fileName: "File7", type: "file" },
//                 ] }
//             ] }
//         ] },
//         { fileName: "File5", type: "file" },
//         { fileName: "File6", type: "file" }
//     ],
//     "Folder2": [
//         { fileName: "File7", type: "file" },
//         { fileName: "File8", type: "file" },
//         { fileName: "Subfolder3", type: "folder", contents: [
//             { fileName: "File9", type: "file" },
//             { fileName: "File10", type: "file" },
//         ] },
//         { fileName: "File11", type: "file" },
//         { fileName: "File12", type: "file" }
//     ],
// };

// function mainFunction() {
//     // Function to check if an object is a dictionary (folder)
//     function isDictionary(item) {
//         return item !== null && typeof item === 'object' && item.type === 'folder';
//     }

//     // Function to create folder and display files or subfolders
//     function createFolder(folderName, files) {
//         const folderDiv = document.createElement('div');
//         folderDiv.classList.add('folder');

//         const folderIcon = document.createElement('img');
//         folderIcon.src = "../Images/Foldericon.png";
//         folderIcon.setAttribute('id', 'size');

//         const iconDiv = document.createElement('div');
        
//         const folderHead = document.createElement('h3');
//         folderHead.textContent = folderName;
//         folderHead.classList.add('folderTitle');

//         const headDiv = document.createElement('div');

//         iconDiv.appendChild(folderIcon);
//         headDiv.appendChild(folderHead);

//         folderDiv.appendChild(iconDiv);
//         folderDiv.appendChild(headDiv);

//         const folderContentDiv = document.createElement('div');
//         folderContentDiv.classList.add('folder-content');
//         folderContentDiv.style.display = 'none';  // Ensure folder content is initially hidden
        
//         // Loop through files and display them
//         files.forEach(item => {
//             if (isDictionary(item)) {
//                 // Handle subfolder
//                 const subfolderDiv = createFolder(item.fileName, item.contents);
//                 folderContentDiv.appendChild(subfolderDiv);
//             } else {
//                 // Handle file
//                 const fileDiv = document.createElement('div');
//                 fileDiv.classList.add('file');

//                 const fileIcon = document.createElement('img');
//                 fileIcon.src = "../Images/Fileicon.png";
//                 fileIcon.setAttribute('id', 'size');
        
//                 const fileiconDiv = document.createElement('div');
                
//                 const fileHead = document.createElement('h3');
//                 fileHead.textContent = item.fileName;
//                 fileHead.classList.add('fileTitle');
        
//                 const headDiv = document.createElement('div');
                
//                 fileiconDiv.appendChild(fileIcon);
//                 headDiv.appendChild(fileHead);

//                 fileDiv.appendChild(fileiconDiv);
//                 fileDiv.appendChild(headDiv);

//                 folderContentDiv.appendChild(fileDiv);
//             }
//         });

//         // Add click event to folderDiv to toggle folderContentDiv visibility
//         folderDiv.addEventListener('click', (event) => {
//             // Prevent click event from propagating to folderContentDiv
//             event.stopPropagation();
//             folderContentDiv.style.display = folderContentDiv.style.display === 'none' ? 'block' : 'none';
//         });

//         // Add click event to folderContentDiv for handling actions inside the folder (if needed)
//         folderContentDiv.addEventListener('click', (event) => {
//             event.stopPropagation(); // Prevent folderDiv's click event from firing when interacting with content inside the folder
//             console.log("You clicked inside the folder content.");
//             // Add any functionality related to interacting with files/subfolders here
//         });

//         folderDiv.appendChild(folderContentDiv);
//         return folderDiv;
//     }

//     // Main function to display the entire folder structure
//     function displayDirectory() {
//         const folderContainer = document.getElementById('folderContainer');
        
//         // Loop through the directory and create folder structures
//         for (const folderName in directory) {
//             if (directory.hasOwnProperty(folderName)) {
//                 const folderDiv = createFolder(folderName, directory[folderName]);
//                 folderContainer.appendChild(folderDiv);
//             }
//         }
//     }

//     // Call the displayDirectory function to render the folder structure on page load
//     displayDirectory();
// }

// // Execute the main function when the page loads
// window.onload = mainFunction;
    

// // The search functionality
