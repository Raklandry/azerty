const inputs = document.querySelectorAll('.input');
const errors = document.querySelectorAll('.invalid-feedback');
window.addEventListener('load', () =>{
    inputs.forEach(input => {
        if(input.value !== ''){
            let parent = input.parentNode.parentNode;
            parent.classList.add('focus');
        }
    });
})
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

function er(){
    errors.forEach(error => {
        error.parentNode.style.display = 'none'
    })
    
}

inputs.forEach(input => {
    input.addEventListener('focus', focus);
    input.addEventListener('change', er);
    input.addEventListener('blur', blur);
});