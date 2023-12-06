import switchGenerateButton from "./switch-generate-button";
import deleteIdFromQueue from "./delete-id-from-queue";
import setPercent from "./set-percent";
import setCookie from "../createCookie";

const stopGenerating = async (taskID, premiumBody) => {

    switchGenerateButton(document.querySelector('.generate'), 'stopped');
    if (taskID !== "") { // Check if taskID is not empty before attempting to delete
        alert('pirmas');
        let stopped = await deleteIdFromQueue(taskID, premiumBody);
        setPercent('');
        taskID = ""; // Reset taskID after stopping
        setCookie('lastGeneratedId', '',1);
    }
}

export default stopGenerating;