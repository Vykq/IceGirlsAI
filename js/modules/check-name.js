import isEmpty from "./is-empty";

const checkName = (nameInput, nameMsg) => {
    if (nameInput.classList.contains('error')) {
        return false;
    }
    if (isEmpty(nameInput)) {
        nameInput.classList.add('error');
        nameMsg.textContent = themeUrl.name_empty;
        return false;
    };
    return true;
}

export default checkName;

