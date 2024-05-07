
import { sprintf, __ } from '@wordpress/i18n';
import { registerPaymentMethod } from '@woocommerce/blocks-registry';
import { decodeEntities } from '@wordpress/html-entities';
import { getSetting } from '@woocommerce/settings';

const settings = getSetting( 'sharecommerce_data', {} );

const defaultLabel = __(
	'Share Commerce Payments',
	'woo-gutenberg-products-block'
);

const label = decodeEntities( settings.title ) || defaultLabel;
const icons = decodeEntities( settings.icon );

/**
 * Content component
 */
const Content = () => {
	return decodeEntities( settings.description || '' );
};
/**
 * Label component
 *
 * @param {*} props Props from payment API.
 */
// const Label = ( props ) => {
// 	const { PaymentMethodLabel, PaymentMethodIcons } = props.components;
// 	return (<div><PaymentMethodLabel text={ label } /> <PaymentMethodIcons icons={icons} /></div>);
// };


const PaymentMethodLabel = (props) => {
    
    const {PaymentMethodLabel: Label, PaymentMethodIcons} = props.components;
    return (
        <div>
            <Label text={label}/>
            <PaymentMethodIcons icons={icons}/>
        </div>
    )
};

/**
 * Share Commerce payment method config object.
 */

const sharecommercepaymentmodel = {
	name: "sharecommerce",
	label: <PaymentMethodLabel />,
	content: <Content />,
	edit: <Content />,
	canMakePayment: () => true,
	ariaLabel: label,
	supports: {
		features: settings.supports,
	},
};

registerPaymentMethod( sharecommercepaymentmodel );
