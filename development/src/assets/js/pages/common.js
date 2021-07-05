const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';

var KTAppSettings = {
	breakpoints: {
		sm: 576,
		md: 768,
		lg: 992,
		xl: 1200,
		xxl: 1400
	},
	colors: {
		theme: {
			base: {
				white: '#ffffff',
				primary: '#3699FF',
				secondary: '#E5EAEE',
				success: '#1BC5BD',
				info: '#8950FC',
				warning: '#FFA800',
				danger: '#F64E60',
				light: '#E4E6EF',
				dark: '#181C32'
			},
			light: {
				white: '#ffffff',
				primary: '#E1F0FF',
				secondary: '#EBEDF3',
				success: '#C9F7F5',
				info: '#EEE5FF',
				warning: '#FFF4DE',
				danger: '#FFE2E5',
				light: '#F3F6F9',
				dark: '#D6D6E0'
			},
			inverse: {
				white: '#ffffff',
				primary: '#ffffff',
				secondary: '#3F4254',
				success: '#ffffff',
				info: '#ffffff',
				warning: '#ffffff',
				danger: '#ffffff',
				light: '#464E5F',
				dark: '#ffffff'
			}
		},
		gray: {
			'gray-100': '#F3F6F9',
			'gray-200': '#EBEDF3',
			'gray-300': '#E4E6EF',
			'gray-400': '#D1D3E0',
			'gray-500': '#B5B5C3',
			'gray-600': '#7E8299',
			'gray-700': '#5E6278',
			'gray-800': '#3F4254',
			'gray-900': '#181C32'
		}
	},
	'font-family': 'Poppins'
};

function formatTelefone(v) {
	v = v.replace(/\D/g, '');
	v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
	v = v.replace(/(\d)(\d{4})$/, '$1-$2');

	return v;
}

function formatData(date, hasHour, hasSeconds, divider = ' ') {
	if (date) {
		var hora = '';

		if (hasHour) {
			hora = divider + date.slice(11, 16);

			if (hasSeconds) {
				hora += date.slice(16, 19);
			}
		}

		var date = date.slice(0, 10).split('-');

		date = date[2] + '/' + date[1] + '/' + date[0] + hora;
	}

	return date;
}

function formatMoney(valor, prefix = true) {
	if (valor) {
		valor = parseFloat(valor);

		if (prefix) {
			valor = valor.toLocaleString('pt-br', {
				style: 'currency',
				currency: 'BRL'
			});
		} else {
			valor = valor.toLocaleString('pt-BR', {
				minimumFractionDigits: 2
			});
		}
	}

	return valor;
}

var arrows;
if (KTUtil.isRTL()) {
	arrows = {
		leftArrow: '<i class="la la-angle-right"></i>',
		rightArrow: '<i class="la la-angle-left"></i>'
	};
} else {
	arrows = {
		leftArrow: '<i class="la la-angle-left"></i>',
		rightArrow: '<i class="la la-angle-right"></i>'
	};
}

Dropzone.prototype.defaultOptions = {
	...Dropzone.prototype.defaultOptions,
	...{
		dictDefaultMessage: 'Solte aqui os arquivos para enviar', // Drop files here to upload";
		dictFallbackMessage: 'Seu navegador não suporta uploads de arrastar e soltar.', // Your browser does not support drag'n'drop file uploads.";
		dictFallbackText: 'Por favor, use o formulário abaixo para enviar seus arquivos como antigamente.', // Please use the fallback form below to upload your files like in the olden days.";
		dictFileTooBig: 'O arquivo é muito grande ({{filesize}}MB). Tamanho máximo permitido: {{maxFilesize}}MB.', // File is too big ({{filesize}}MB). Max filesize: {{maxFilesize}}MB.";
		dictInvalidFileType: 'Você não pode fazer upload de arquivos desse tipo.', // You can't upload files of this type.";
		dictResponseError: 'O servidor respondeu com o código {{statusCode}}.', // Server responded with {{statusCode}} code.";
		dictCancelUpload: 'Cancelar envio', // Cancel upload";
		dictCancelUploadConfirmation: 'Tem certeza de que deseja cancelar este envio?', // Are you sure you want to cancel this upload?";
		dictRemoveFile: 'Remover arquivo', // Remove file";
		dictRemoveFileConfirmation: null, // null;
		dictMaxFilesExceeded: 'Você só pode fazer upload de {{maxFiles}} arquivos.' // You can only upload {{maxFiles}} files.";
	}
};
