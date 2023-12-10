import switchGenerateButton from "./switch-generate-button";
import deleteIdFromQueue from "./delete-id-from-queue";
import setPercent from "./set-percent";
import setCookie from "../createCookie";
import getCookieValue from "../getCookieValue";

const stopGenerating = async (taskID, premiumBody) => {
    switchGenerateButton(document.querySelector('.generate'), 'stopped');

    try {
        if (taskID !== "") {
            let stopped = await deleteIdFromQueue(taskID, premiumBody);
            setPercent('');
        } else if (getCookieValue('lastGeneratedId') !== "") {
            taskID = getCookieValue('lastGeneratedId');
            let stopped = await deleteIdFromQueue(taskID, premiumBody);
            setPercent('');
        }

        taskID = ""; // Reset taskID after stopping
        setCookie('lastGeneratedId', '', 1);
    } catch (error) {
        console.error('Error while stopping generation:', error);
    }
};

export default stopGenerating;