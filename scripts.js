// Function to generate Tambola boxes
function generateBoxes() {
    // Define an array to hold numbers from 1 to 90
    let numbers = Array.from({ length: 90 }, (_, i) => i + 1);
    
    // Shuffle the array to randomize the numbers
    numbers = shuffle(numbers);
    
    // Define an array to hold 6 boxes
    let boxes = [];
    
    // Divide the array into 6 parts, each representing one box
    for (let i = 0; i < 6; i++) {
        boxes.push(numbers.slice(i * 15, (i + 1) * 15));
    }
    
    // Loop through each box
    for (let box of boxes) {
        // Fill the remaining cells with 0
        while (box.length < 3 * 9) {
            box.push(0);
        }
        
        // Randomly shuffle the box to distribute the numbers
        box = shuffle(box);
        
        // Arrange the numbers within each column according to their ranges
        for (let col = 0; col < 9; col++) {
            let start = col * 10 + 1;
            let end = start + 9;
            let columnNumbers = box.filter(num => num >= start && num < end);
            columnNumbers.sort((a, b) => a - b);
            box.splice(col * 3, 9, ...columnNumbers);
        }
        
        // Display the box
        displayBox(box);
    }
}

// Function to shuffle an array
function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// Function to display a box
function displayBox(box) {
    console.log(box.slice(0, 9).join(', '));
    console.log(box.slice(9, 18).join(', '));
    console.log(box.slice(18, 27).join(', '));
    console.log('');
}

// Generate Tambola boxes
generateBoxes();
