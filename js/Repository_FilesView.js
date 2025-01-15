// Testing

const pp = viewTypeDictionary;
console.log(pp);

const pp2 = filePathDictionary;
console.log(pp2);

const grouped = {};

// Iterate through the dictionary
for (const [key, value] of Object.entries(filePathDictionary)) {
    // If the array for this value doesn't exist, create it
    if (!grouped[value]) {
        grouped[value] = [];
    }
    // Add the key to the corresponding array
    grouped[value].push(key);
}

// Log the result
for (const [value, array] of Object.entries(grouped)) {
    console.log(`Array ${value}:`, array);
}

const gridContainer = document.getElementById('container mt-5');
const gridItemDiv = document.getElementById('folder');

gridItemDiv.addEventListener('click', function() {
    // Clear the grid and display the new items
    displayNewItems();
});

function displayNewItems() {
    // Clear the gridContainer
    gridContainer.innerHTML = '';

    // Iterate through the newData array and create div elements
    newData.forEach(item => {
        const div = document.createElement('div');
        div.classList.add('gridItem');
        div.textContent = item;
        gridContainer.appendChild(div);
    });

    // Show the backButtonContainer
    backButtonContainer.style.display = 'block';
    isNewDataDisplayed = true; // Mark that new data is being displayed
}

// Testing Stop