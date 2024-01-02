import getCookieValue from "./getCookieValue";
import checkTaskStatus from "./api/checkTaskStatus";
import switchGenerateButton from "./api/switch-generate-button";
import showQueueInfo from "./api/show-queue-info";
import setPercent from "./api/set-percent";
import apiGetQueue from "./api/api-get-queue";
import getPosition from "./api/get-position";
import updateQueueInfo from "./api/update-queue-info";
import getImage from "./api/get-image";
import loadImage from "./api/load-image";
import createPost from "./api/create-post";
import setCookie from "./createCookie";

const cookieChange = async (openedPageCookie, premiumBody, intervalId) => {
    let status = await showQueueInfo(openedPageCookie, premiumBody);
    if(status === "done"){
        setCookie('lastGeneratedId', '', 1);
    } else {
        console.log('wtf');
        const isGeneratingAlreadyID = getCookieValue('lastGeneratedId');
        console.log(openedPageCookie + 'opne');
        if (isGeneratingAlreadyID !== "") {
            console.log('isGeneratingAlreadyID' + isGeneratingAlreadyID)
            let taskStatus = checkTaskStatus(isGeneratingAlreadyID);
            switchGenerateButton(document.querySelectorAll('.generate'), 'start');
            document.querySelector('.stop-generate').disabled = true;
            if (taskStatus) {
                status = await showQueueInfo(isGeneratingAlreadyID, premiumBody);
                console.log('status' + status)
                if (status !== undefined) {
                    document.querySelector('.site-loader').classList.add('hide');
                    if (status !== "done") {
                        while (status !== "done") {
                            setPercent('66');
                            console.log('as cia');
                            let apiGetQueueInfo = await apiGetQueue(premiumBody);
                            if (apiGetQueueInfo) {
                                const currentPos = await getPosition(isGeneratingAlreadyID, premiumBody);

                                let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                                const totalPendingTasksCount = totalPendingTasksObj.length;
                                await updateQueueInfo(currentPos.pos, '');
                                status = await showQueueInfo(isGeneratingAlreadyID, premiumBody); // Retry until
                                taskStatus = checkTaskStatus(isGeneratingAlreadyID);// status is "done"
                            } else {
                                break;
                            }
                        }

                    } else {
                        setPercent('99');
                        let imgdata = await getImage(isGeneratingAlreadyID, premiumBody);
                        if (imgdata.image) {
                            let tempseed = imgdata.infotext;
                            const seedMatch = tempseed.match(/Seed: (\d+)/);

                            await loadImage(imgdata.image, premiumBody, '9/16');
                            await createPost('1', imgdata.image, imgdata.infotext, isGeneratingAlreadyID, premiumBody);
                            setPercent('100');
                            document.querySelector('.upscale').classList.remove('hidden');
                            setCookie('lastGeneratedId', '', 1);
                            switchGenerateButton(document.querySelector('.generate'), 'end');
                        } else {
                            setPercent('Error');
                        }
                    }
                } else {
                    switchGenerateButton(document.querySelectorAll('.generate'), 'stopped');
                    setCookie('lastGeneratedId', '', 1);
                    setPercent('Error');
                }


            } else {
                switchGenerateButton(document.querySelectorAll('.generate'), 'stopped');
                setCookie('lastGeneratedId', '', 1);
                setPercent('Error');
            }
            // let imgdata = await getImage(isGeneratingAlreadyID, premiumBody);
            // if (imgdata.image) {
            //     let tempseed = imgdata.infotext;
            //     const seedMatch = tempseed.match(/Seed: (\d+)/);
            //     await loadImage(imgdata.image, premiumBody, '9/16');
            //     await createPost('1', imgdata.image, imgdata.infotext, isGeneratingAlreadyID, premiumBody);
            //     setPercent('100');
            //     document.querySelector('.upscale').classList.remove('hidden');
            //     setCookie('lastGeneratedId', '', 1);
            //     switchGenerateButton(document.querySelector('.generate'), 'end');
            // } else {
            //     setPercent('Error');
            // }
        } else {
            switchGenerateButton(document.querySelectorAll('.generate'), 'stopped');
            setCookie('lastGeneratedId', '', 1);
            return;
        }

    }
};

export default cookieChange;