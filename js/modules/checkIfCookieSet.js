import getCookie from "./getCookie";
import switchGenerateButton from "./api/switch-generate-button";
import isPremium from "./api/is-premium";
import apiGetQueue from "./api/api-get-queue";
import setPercent from "./api/set-percent";
import showQueueInfo from "./api/show-queue-info";
import getPosition from "./api/get-position";
import updateQueueInfo from "./api/update-queue-info";
import getSeed from "./api/get-seed";
import getImage from "./api/get-image";
import loadImage from "./api/load-image";
import createPost from "./api/create-post";
import setCookie from "./createCookie";
import getCookieValue from "./getCookieValue";

const checkIfCookieSet = async (stopGenerateFlag) => {



    const lastID = getCookieValue('lastGeneratedId');
    let seed = "";
    let lastSeed = '';


  if(lastID !== ""){
      let taskID = lastID;
      switchGenerateButton(document.querySelector('.generate'), 'start');
      const userStatus = await isPremium(taskID);
      let apiGetQueueInfo = await apiGetQueue(userStatus, stopGenerateFlag);
      let currentTaskID = apiGetQueueInfo.currentTaskId;

      if (currentTaskID !== taskID) {
          setPercent('16');
          if (userStatus) {
              if(!stopGenerateFlag) {
                  setPercent('33');
                  let status = await showQueueInfo(taskID, userStatus);
                  while (status !== "done") {
                      if(!stopGenerateFlag) {
                          setPercent('66');
                          console.log('abc');
                          apiGetQueueInfo = await apiGetQueue(userStatus, stopGenerateFlag);
                          if(apiGetQueueInfo !== null){
                              const currentPos = await getPosition(taskID, userStatus);
                              let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                              const totalPendingTasksCount = totalPendingTasksObj.length;
                              await updateQueueInfo(currentPos.pos, '');
                              status = await showQueueInfo(taskID, userStatus);
                              if(status)
                                  if (stopGenerateFlag) {
                                      break;
                                  }
                              await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                          } else {
                          break;
                      }
                      } else {
                          return;
                      }
                  }
              } else {
                  return;
              }

          } else {
              if (!stopGenerateFlag) {
                  setPercent('33');
                  let currentTaskID = apiGetQueueInfo.currentTaskId;
                  while (currentTaskID !== taskID) {
                      if(!stopGenerateFlag) {
                          setPercent('premium');
                          console.log('aga');
                          apiGetQueueInfo = await apiGetQueue(userStatus, stopGenerateFlag);
                          if(apiGetQueueInfo) {
                              const currentPos = await getPosition(taskID, userStatus);
                              let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                              const totalPendingTasksCount = totalPendingTasksObj.length;
                              updateQueueInfo(currentPos.pos, '');
                              currentTaskID = apiGetQueueInfo.currentTaskId;
                              if (taskID === "" || stopGenerateFlag) {
                                  break;
                              }
                              await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                          } else {
                              stopGenerateFlag = true;
                              break;
                          }
                      } else {
                          break;
                      }
                  }
                  if(!stopGenerateFlag){
                      let status = await showQueueInfo(taskID,userStatus); // Wait for the result of showQueueInfo
                  }

              }

              if (!stopGenerateFlag) {
                  let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
                  while (status !== "done") {
                      if(!stopGenerateFlag) {
                          status = await showQueueInfo(taskID, userStatus); // Retry until status is "done"
                          setPercent('66');
                          console.log('agaga');
                          apiGetQueueInfo = await apiGetQueue(userStatus, stopGenerateFlag);
                          if(apiGetQueueInfo) {
                              const currentPos = await getPosition(taskID, userStatus);

                              let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                              const totalPendingTasksCount = totalPendingTasksObj.length;
                              await updateQueueInfo(currentPos.pos, '');
                              if (stopGenerateFlag) {
                                  break;
                              }
                              await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                          } else {
                              stopGenerateFlag = true;
                              break;
                          }
                      } else {
                          break;
                      }
                  }
                  setPercent('66');
              }
          }

      } else {

          if(!stopGenerateFlag) {
              let status = await showQueueInfo(taskID, userStatus); // Wait for the result of showQueueInfo
              seed = await getSeed(taskID, userStatus);
              setPercent('66');
              while (status !== "done") {
                  if(!stopGenerateFlag) {
                      setPercent('66');
                      console.log('xd');
                      apiGetQueueInfo = await apiGetQueue(userStatus, stopGenerateFlag);
                      if(apiGetQueueInfo) {
                          const currentPos = await getPosition(taskID, userStatus);

                          let totalPendingTasksObj = apiGetQueueInfo.pendingTasks;
                          const totalPendingTasksCount = totalPendingTasksObj.length;
                          await updateQueueInfo(currentPos.pos, '');
                          status = await showQueueInfo(taskID, userStatus); // Retry until status is "done"
                          seed = await getSeed(taskID, userStatus);
                          if (stopGenerateFlag) {
                              break;
                          }
                          await new Promise(resolve => setTimeout(resolve, 1000)); // Timeout
                      } else {
                          stopGenerateFlag = true;
                          break;
                      }
                  } else {
                      break;
                  }
              }
          }
      }
      if(!stopGenerateFlag) {
          setPercent('99');
          const imgdata = await getImage(taskID, userStatus);
          if (imgdata.image) {
              let tempseed = imgdata.infotext;
              const seedMatch = tempseed.match(/Seed: (\d+)/);

              if (seedMatch) {
                  seed = seedMatch[1];
                  lastSeed = seed;
                  console.log('Done seed: ' + seed); // The extracted seed value as a string
              }
              switchGenerateButton(document.querySelector('.generate'), 'end');
              await loadImage(imgdata.image, userStatus, '9/16'); //get aspect ratio functon todo
              await createPost(1, imgdata.image, imgdata.infotext, taskID, '9/16');
              setPercent('100');
              document.querySelector('.upscale').classList.remove('hidden');

          } else {
              setPercent('Error');
          }
      } else {
          switchGenerateButton(document.querySelector('.generate'), 'stopped');
          setCookie('lastGeneratedId', '',1);
          stopGenerateFlag = false;
      }
  }




}

export default checkIfCookieSet;