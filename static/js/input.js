const inputs = document.querySelectorAll(".form-input");

const focus = (e) => {
    let parent = e.target.parentNode.parentNode;
    parent.classList.add("focus");
}

const blur = (e) => {
    let parent = e.target.parentNode.parentNode;
    if (e.target.value === "") {
        parent.classList.remove("focus");
    }
}
inputs.forEach(input => {
    input.addEventListener("focus", focus);
    input.addEventListener("blur", blur);
})