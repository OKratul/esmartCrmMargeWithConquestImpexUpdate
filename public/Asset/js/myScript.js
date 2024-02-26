let selectType = document.getElementById('select_type');

   selectType.addEventListener('change', function (){

       let selectedValue = this.value;

       let genarelPrice = document.querySelector('.price');

       if (selectedValue === 'Variable_product'){

           genarelPrice.style.display = 'none';
       }
       else if(selectedValue === 'simple_product') {
           genarelPrice.style.display = 'block';
       }

   });

   let general = document.getElementById('general');
   let inventory = document.getElementById('inventory');
   let linkedProduct = document.getElementById('linkedProduct');
   let attributes = document.getElementById('attributes');
   let advanced = document.getElementById('advanced');
   let bulkDiscount = document.getElementById('bulkDiscount');

    const tabs = document.querySelectorAll('.tabs li');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            const tabId = this.id;
            showTabContent(tabId);
        });
    });

    function showTabContent(tabId) {
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });

        tabContents.forEach(function(tabContent) {
            tabContent.style.display = 'none';
        });

        const selectedTab = document.getElementById(tabId);
        const selectedTabContent = document.querySelector(`.${tabId}`);

        if (selectedTab && selectedTabContent) {
            selectedTab.classList.add('active');
            selectedTabContent.style.display = 'block';
        }
    }


    let smsModalButton = document.querySelectorAll('.sms-modal-button');















