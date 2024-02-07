const checkFiles = (fileinput, nameMsg, cv) => {
    if (fileinput.classList.contains('error')) {
        return false;
    }

    if (fileinput.files.length === 0) {
        cv.classList.add('error');
        nameMsg.textContent = themeUrl.file_empty;
        return false;
    }

    const allowedFormats = ['jpg', 'jpeg'];
    const fileName = fileinput.files[0].name;
    const fileExtension = fileName.split('.').pop().toLowerCase();

    if (!allowedFormats.includes(fileExtension)) {
        cv.classList.add('error');
        nameMsg.textContent = themeUrl.invalid_file_format;
        return false;
    }

    const fileSize = fileinput.files[0].size; // in bytes
    const maxSizeInBytes = 1024 * 1024; // 1MB
    if (fileSize > maxSizeInBytes) {
        cv.classList.add('error');
        nameMsg.textContent = themeUrl.file_too_large;
        return false;
    }

    return true;
}

export default checkFiles;