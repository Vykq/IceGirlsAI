const updateRangeValue = () => {

    const rangeSliders = document.querySelectorAll('input[type="range"]');

    rangeSliders.forEach(input => {
        input.addEventListener('input', (e) => {
            let rangeValueOutput = input.nextElementSibling;
            rangeValueOutput.textContent = input.value;
        })
    })

}
updateRangeValue();
export default updateRangeValue;