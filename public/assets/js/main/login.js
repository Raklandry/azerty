const inputs = document.querySelectorAll('.input');

function focus(){
    let parent = this.parentNode.parentNode;
    parent.classList.add('focus');
}

function blur(){
    let parent = this.parentNode.parentNode;
    if(this.value == ''){
        parent.classList.remove('focus');
    }
}

inputs.forEach(input => {
    input.addEventListener('focus', focus);
    input.addEventListener('blur', blur);
});