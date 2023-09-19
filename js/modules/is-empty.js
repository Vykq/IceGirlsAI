function isEmpty(field) {
    if (field.value.replace(/\s+/g, '') == '') {
        return true;
    }
    return false;
}

export default isEmpty;
