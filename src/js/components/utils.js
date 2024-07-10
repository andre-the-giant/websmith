import CONST from './const';
const fetchCSVData = async (url)=>{
  try {
    const response = await fetch(url);
    let csvData = await response.text();
    csvData = csvData.replace(/[^A-Z0-9,\n]+/g, '');
    csvData = csvData.replace(/\r\n/g, '\n');
    return csvData;
  } catch (error) {
    throw new Error('There was an error fetching the CSV data: ' + error.message);
  }
}
const processCSVData = (csvData)=>{
  const csvRows = csvData.split('\n');
  const csvHeaders = csvRows[0].split(',');
  const columnData = {};
  for (let j = 0; j < csvHeaders.length; j++) {
    const columnId = csvHeaders[j];
    const columnValues = [];
    for (let i = 1; i < csvRows.length; i++) {
      const csvRow = csvRows[i].split(',');
      if (csvRow.length === 1 && csvRow[0] === '') {
        continue; // Skip empty row
      }
      const cellValue = csvRow[j];
      if (cellValue === '') {
        continue; // Skip empty cell
      }
      columnValues.push(cellValue);
    }
    columnData[columnId] = columnValues;
  }
  return columnData;
}

const isValidPartialPostalCode = (postalCode)=>{
    const postalcodelength = postalCode.length;
    if (postalcodelength < 1 || postalcodelength > 6) {
        return false;
    }
    const pattern = [
        '^[KLMNP]',
        '[0-9]',
        '[A-Z]',
        '[0-9]',
        '[A-Z]',
        '[0-9]$'
    ].slice(0, postalcodelength).join('');
    const regex = new RegExp(pattern);
    return regex.test(postalCode);
}
const isPostalcodeInthelist = (postalcode, postalcodeList) => {
  for (const pc of postalcodeList) {
      if (pc.length === 3 && (pc.startsWith(postalcode.substring(0, 3)) || pc.includes(postalcode))) {
      return true;
      } else if (pc.length === 4 && pc.startsWith(postalcode.substring(0, 4))) {
      return true;
      } else if (pc.length === 5 && pc.startsWith(postalcode.substring(0, 5))) {
      return true;
      } else if (pc.length === 6 && pc === postalcode) {
      return true;
      }
  }
  return false;
}

// Define a function to get the territory data
const getTerritoryData = async ()=>{
try {
    // Check if the column data is already stored in localStorage
    const storedTerritoryData = JSON.parse(localStorage.getItem('territoryData'));
    if (storedTerritoryData && Date.now() - storedTerritoryData.lastFetchTime <= 24 * 60 * 60 * 1000) {
      // Use the stored column data
      return storedTerritoryData.data;
    } else {
      const urls = CONST.urls;
      const retrivedData = {}
      for (const territory in urls) {
        const data = await fetchCSVData(urls[territory]);
        retrivedData[territory] = await processCSVData(data);
      }
      // Store the column data and last fetch time in localStorage
      localStorage.setItem('territoryData', JSON.stringify({
        data: retrivedData,
        lastFetchTime: Date.now()
      }));

      // Return the column data object
      return retrivedData;
    }
  } catch (error) {
    // alert('There was an error fetching the data. Please try again later.');
    throw error;
  }
}

const getServicesData = async ()=>{
  try {
    // Check if the column data is already stored in localStorage
    const storedServicesData = JSON.parse(localStorage.getItem('servicesData'));
    if (storedServicesData && Date.now() - storedServicesData.lastFetchTime <= 24 * 60 * 60 * 1000) {
      // Use the stored column data
      return storedServicesData.data;
    } else {
      const urls = CONST.urls;
      const retrivedData = await fetch(`/inc/services.json.php`).then(response => response.json());
      // Store the column data and last fetch time in localStorage
      localStorage.setItem('servicesData', JSON.stringify({
        data: retrivedData,
        lastFetchTime: Date.now()
      }));

      // Return the column data object
      return retrivedData;
    }
  } catch (error) {
    // alert('There was an error fetching the data. Please try again later.');
    throw error;
  }
}

const loadCalendarInIFrame = (serviceTitle,calendarID,containerID = 'services_list' )=>{
    // Create an iframe element
    const iframe = document.createElement('iframe');
    // Set the iframe's source URL to the Acuity scheduler URL
    iframe.src = 'https://app.acuityscheduling.com/schedule.php?owner=17072780&calendarID='+calendarID;

    // Set any additional options you want to pass to the embed.js script
    var options = {
    height: 800,
    width: '100%',
    frameborder: 0
    };

    // Set the iframe's attributes based on the options object
    for (var key in options) {
    iframe.setAttribute(key, options[key]);
    }

    // Append the iframe to the container element
    const container = document.getElementById(containerID);
    container.innerHTML=`<h3 id="booking-header">Booking ${serviceTitle} ${(typeof territory !=='undefined')?`in ${territory}`:``}</h3>`;
    document.getElementById('booking-header').appendChild(iframe);
    // Load the embed.js script
    var script = document.createElement('script');
    script.src = 'https://embed.acuityscheduling.com/js/embed.js';
    script.type = 'text/javascript';
    container.appendChild(script);
    container.scrollIntoView({ behavior: "smooth"});
}

const loadCSS = ()=>{
    // load module style
    const link = document.createElement("link");
    link.rel = "stylesheet",
    link.type = "text/css",
    link.href = `${CONST.hostUrl}/barbequeprobooking.css`,
    document.head.appendChild(link);
    // load acuity style 
    const acuitystyle = document.createElement("link");
    acuitystyle.rel = "stylesheet",
    acuitystyle.type = "text/css",
    acuitystyle.href = "https://cdn-marketing.acuityscheduling.com/built/csp/schedule.css?v=2669c2",
    document.head.appendChild(acuitystyle);
  }

const validateInput = ()=>{
      const postalCodeInput = document.getElementById('postalcode');
      let text = postalCodeInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
      postalCodeInput.value = text;
      const errorDiv = document.getElementById('error-postalcode');
      errorDiv.style.display = 'none';
      if (text.length>0 && !isValidPartialPostalCode(text)){
          errorDiv.style.display = 'block';
          postalCodeInput.value = text.substring(0,text.length-1);
      }
  }
const validateSubmit = (event)=>{
      event.preventDefault();
      const postalCodeInput = document.getElementById('postalcode');
      let text = postalCodeInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
      postalCodeInput.value = text;
      const errorDiv = document.getElementById('error-postalcode');
      errorDiv.style.display = 'none';
      if (text.length<6 || !isValidPartialPostalCode(text)){
          errorDiv.style.display = 'block';
          return false;
      }
      // now let's get the proper ID from the input
      else if (text.length===6 && isValidPartialPostalCode(text)){
          // now we can fetch our data or use the one in localStorage
          // Call the getTerritoryData() function to get the territories data
          getTerritoryData()
          .then(data => {
            // check which territory is the postal code from
              const getTerritory = ()=>{
                  for (const territory in CONST.urls) {
                      if(isPostalcodeInthelist(text,data[territory]["POSTALCODE"])){
                          return territory;
                      }
                  }
                  return false;
              }
              const userTerritory = getTerritory();
              function getCookieExpirationDate(days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                return date.toUTCString();
              }
              var expirationDays = 30; 
              document.cookie = `userTerritory=${JSON.stringify({territory: userTerritory,postalcode: text})}; expires=${getCookieExpirationDate(expirationDays)}; path=/;`;
              if(!!userTerritory){
                  window.location.href=`/location/${userTerritory}`
              }
              else{
                  window.location.href=`/area-not-serviced`
              }
          })
          .catch(error => {
            // Display an error message if there is an error
            //alert(error.message);
          });
      }
  }

const utils = {
  getTerritoryData:getTerritoryData,
  getServicesData:getServicesData,
  loadCalendarInIFrame:loadCalendarInIFrame,
  loadCSS: loadCSS,
  validateInput:validateInput,
  validateSubmit:validateSubmit
}

export default utils;
