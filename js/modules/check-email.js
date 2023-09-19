import validateEmail from "./validate-email";
import isEmpty from "./is-empty";

const checkEmail = (mailInput, mailMsg) => {
    if (mailInput.classList.contains('error')) {
        return false;
    }
    if (isEmpty(mailInput)) {
        mailInput.classList.add('error');
        mailMsg.textContent = themeUrl.mail_empty;
        return false;
    };
    if (!validateEmail(mailInput.value)) {
        mailInput.classList.add('error');
        mailMsg.textContent = themeUrl.mail_error;
        return false;
    }
    return true;
}

export default checkEmail;
