(()=>{"use strict";const e=window.React,t=window.wp.i18n,n=window.wc.wcBlocksRegistry,c=window.wp.htmlEntities,o=(0,window.wc.wcSettings.getSetting)("sharecommerce_data",{}),i=(0,t.__)("Share Commerce Payments","woo-gutenberg-products-block"),a=(0,c.decodeEntities)(o.title)||i,r=(0,c.decodeEntities)(o.icon),s=()=>(0,c.decodeEntities)(o.description||""),l={name:"sharecommerce",label:(0,e.createElement)((t=>{const{PaymentMethodLabel:n,PaymentMethodIcons:c}=t.components;return(0,e.createElement)("div",null,(0,e.createElement)(n,{text:a}),(0,e.createElement)(c,{icons:r}))}),null),content:(0,e.createElement)(s,null),edit:(0,e.createElement)(s,null),canMakePayment:()=>!0,ariaLabel:a,supports:{features:o.supports}};(0,n.registerPaymentMethod)(l)})();