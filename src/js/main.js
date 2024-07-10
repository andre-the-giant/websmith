// import CONST from './components/const';
import utils from './components/utils';

window.onload = utils.getTerritoryData()
  .then(territoryData => {
      const servicesDiv = document.getElementById('services_list');
      const territory = (servicesDiv !== null)? servicesDiv.dataset.territory : false;
      if(!!territory){
        utils.getServicesData().then(servicesData=>{
          const availableServices = Object.entries(servicesData).filter(ser=>territoryData[territory][ser[0]].length==1);
          const allData = Object.entries(servicesData);
          const loading = document.getElementById('loading');
          loading.style.display = 'none';
          for (const service of allData) {
            const targetDiv = document.getElementById(`service_${service[0]}`)
            if(availableServices.some(subArray => subArray.includes(service[0]))){
              targetDiv.classList.add("available");
              const ctabutton = targetDiv.querySelector('button');
              ctabutton.style.display ='block';
              ctabutton.removeAttribute('disabled');
              ctabutton.dataset.calendarid=territoryData[territory][service[0]][0];
              ctabutton.addEventListener('click',()=>{utils.loadCalendarInIFrame(service[1]['title'],territoryData[territory][service[0]][0],'allservices')})
            }
            else{
               targetDiv.classList.add("unavailable");
            }
          }   
        });
      }
  });

const theForm = document.getElementById('postalcode_lookup');
if (theForm !== null) {
  theForm.addEventListener('submit', utils.validateSubmit);
  const postalCodeInput = document.getElementById('postalcode');
  postalCodeInput.addEventListener('input',utils.validateInput);
}

const ctaBook = document.getElementById('cta-book');
if (ctaBook !== null) {
  utils.getTerritoryData()
    .then(territoryData=>{
      if(territoryData[ctaBook.dataset.territory][ctaBook.dataset.serviceid].length!==0){
        ctaBook.removeAttribute('disabled');
        ctaBook.classList.add('available');
        ctaBook.addEventListener('click', ()=>{
          utils.loadCalendarInIFrame(ctaBook.dataset.title,territoryData[ctaBook.dataset.territory][ctaBook.dataset.serviceid][0],'service-booknow');
        });
      }
      else{
        const booknow = document.getElementById('book-knownuser');
        ctaBook.innerHTML=ctaBook.dataset.noservice;
      }
    })
}

const booknowLocation = document.querySelectorAll('[name="location"]');
const booknowService = document.querySelectorAll('[name="service"]');
let selectedTerritory = '';
let selectedService = '';
if (booknowLocation !== null) {
  booknowLocation.forEach(function(radioButton) {
      radioButton.addEventListener('click', (e)=>{
        const step2 = document.getElementById('booknow_step2');
        step2.classList.add('active');
        const bookingpage = document.getElementById('service-booknow');
        // bookingpage.innerHTML='';
        booknowService.forEach((radioservice)=>{radioservice.checked=false; radioservice.disabled=false})
        const territory=e.target.value;
        selectedTerritory = territory;
         utils.getTerritoryData()
          .then(territoryData => {
            utils.getServicesData().then(servicesData=>{
              const availableServices = Object.entries(servicesData).filter(ser=>territoryData[territory][ser[0]].length==1);
              const allData = Object.entries(servicesData);
              for (const service of allData) {
                const targetDiv = document.getElementById(`service_${service[0]}`)
                if(availableServices.some(subArray => subArray.includes(service[0]))){
                  // targetDiv.checked = true;
                }
                else{
                  targetDiv.disabled = true;
                  targetDiv.classList.add('unavailable')
                }
              }   
            })
          });
      });
      if(radioButton.checked==true){
        radioButton.click();
      }
  });
}
if(booknowService !== null){
  booknowService.forEach((radioButtonServ) => {
     radioButtonServ.addEventListener('click', (e)=>{
        const serv=e.target.value;
        selectedService = serv;
         utils.getTerritoryData()
          .then(territoryData => {
            utils.loadCalendarInIFrame("",territoryData[selectedTerritory][selectedService][0],'service-booknow');
          })
        
     })
  })
}