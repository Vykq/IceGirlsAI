const setPercent = (percent) => {
    const text = document.querySelector('#steps-all');

    if (percent === "Error") {
        text.textContent = percent;
    } else if (percent === "premium") {
        // Create an anchor element
        const premiumLink = document.createElement('a');
        premiumLink.textContent = "PREMIUM";
        premiumLink.href = "/premium/";

        // Append the anchor element to the text container
        text.innerHTML = "Get ";
        text.appendChild(premiumLink);
        text.innerHTML += " to skip the queue.";
    } else {
        text.textContent = percent + "%";
    }
}

export default setPercent;