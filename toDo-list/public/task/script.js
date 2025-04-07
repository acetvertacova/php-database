document.getElementById('addStepButton').addEventListener('click', function() {
    const stepsList = document.getElementById('stepsList');
    const steps = stepsList.getElementsByTagName('li');

    if (steps.length === 0 || steps[steps.length - 1].querySelector('input').value.trim() !== ''){
        let newStep = document.createElement('li');
        let newInput = document.createElement('input');

        newInput.setAttribute('name', 'steps[]');
        newStep.appendChild(newInput);
    
        document.getElementById('stepsList').appendChild(newStep);
    }else{
        alert('Please fill in the previous step before adding a new one.');
    }
});

document.getElementById('removeStepButton').addEventListener('click', function() {
    let stepsList = document.getElementById('stepsList');
    stepsList.removeChild(stepsList.lastElementChild);
});