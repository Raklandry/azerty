const inputs = document.querySelectorAll('.input');

window.addEventListener('load', () =>{
    inputs.forEach(input => {
        if(input.value !== ''){
            let parent = input.parentNode.parentNode.parentNode;
            parent.classList.add('focus');
        }
    });
})

function focus(){
    let parent = this.parentNode.parentNode.parentNode;
    parent.classList.add('focus');
}

function blur(){
    let parent = this.parentNode.parentNode.parentNode;
    if(this.value == ''){
        parent.classList.remove('focus');
    }
}

inputs.forEach(input => {
    input.addEventListener('focus', focus);
    input.addEventListener('blur', blur);
});