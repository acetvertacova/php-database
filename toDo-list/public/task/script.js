document.getElementById('addStepButton').addEventListener('click', function() {
    let newStep = document.createElement('li');
    let newInput = document.createElement('input');

//todo: check if previous step is empty not to add mext step

    newInput.setAttribute('name', 'steps[]');
    newStep.appendChild(newInput);
    
    newStep.appendChild(newInput);
    document.getElementById('stepsList').appendChild(newStep);
});

document.getElementById('removeStepButton').addEventListener('click', function() {
    let stepsList = document.getElementById('stepsList');
    stepsList.removeChild(stepsList.lastElementChild);
});