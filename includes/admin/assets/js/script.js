// form add email
Vue.component( 'mx_agree_link_form', {

	props: {
		agree_link: {
			type: String,
			required: true
		}
	},
	template: `
		<form
			@submit.prevent="saveAgreeLink"
			class="mx-iile-faq-form"
			:class="{mx_invalid_form: formInvalid}"
		>

			<div class="mx-form-saved"
				v-if="form_save_success"
			>
				${mxvjfepcdata_obj_admin.texts.form_saved}
			</div>

			<div class="mx-form-failed"
				v-if="form_failed"
			>
				${mxvjfepcdata_obj_admin.texts.form_failed}
			</div>
			
				
			<div>
				<input 
					type="url"
					v-model="v_agree_link"
				/>
				<small
					v-if="!v_agree_link"
					class="mx_email_empty">Enter an link</small>
			</div>

			<button
				type="submit"
				
			>Save</button>

		</form>
	`,
	data() {
		return {
			v_agree_link: this.agree_link,
			formInvalid: false,
			form_save_success: null,
			form_failed: null
		}
	},
	methods: {
		saveAgreeLink() {

			if(
				this.v_agree_link
			) {

				var _this = this;

				var data = {

					action: 'mx_changev_agree_link',
					nonce: mxvjfepcdata_obj_admin.nonce,
					agree_link: _this.v_agree_link

				};

				jQuery.post( mxvjfepcdata_obj_admin.ajax_url, data, function( response ) {

					if( response === 'saved' ) {

						_this.form_save_success = true

						setTimeout( function() {

							_this.form_save_success = null

						}, 5000 )

					} else {

						_this.form_failed = true

						setTimeout( function() {

							_this.form_failed = null

						}, 5000 )

					}

						

				} );
				

			} else {
				this.formInvalid = true
			}

		}
	}
	
} )

// form add email
Vue.component( 'mx_admin_email_form', {

	props: {
		an_email: {
			type: String,
			required: true
		}
	},
	template: `
		<form
			@submit.prevent="saveEmail"
			class="mx-iile-faq-form"
			:class="{mx_invalid_form: formInvalid}"
		>

			<div class="mx-form-saved"
				v-if="form_save_success"
			>
				${mxvjfepcdata_obj_admin.texts.form_saved}
			</div>

			<div class="mx-form-failed"
				v-if="form_failed"
			>
				${mxvjfepcdata_obj_admin.texts.form_failed}
			</div>
			
				
			<div>
				<input 
					type="email"
					v-model="admin_email"
				/>
				<small
					v-if="!admin_email"
					class="mx_email_empty">Enter an email</small>
				<small
					v-if="!validateEmail( admin_email )"
					class="mx_email_failed">Email is wrong</small>
			</div>

			<button
				type="submit"
				
			>Save</button>

		</form>
	`,
	data() {
		return {
			admin_email: this.an_email,
			formInvalid: false,
			form_save_success: null,
			form_failed: null
		}
	},
	methods: {
		saveEmail() {

			if(
				this.admin_email
			) {

				var _this = this;

				var data = {

					action: 'mx_change_admin_email',
					nonce: mxvjfepcdata_obj_admin.nonce,
					email: _this.admin_email

				};

				jQuery.post( mxvjfepcdata_obj_admin.ajax_url, data, function( response ) {

					if( response === 'saved' ) {

						_this.form_save_success = true

						setTimeout( function() {

							_this.form_save_success = null

						}, 5000 )

					} else {

						_this.form_failed = true

						setTimeout( function() {

							_this.form_failed = null

						}, 5000 )

					}

				} );

			} else {
				this.formInvalid = true
			}

		},
		validateEmail( email ) {

		    let patern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
			
			return patern.test( String( email ).toLowerCase() )

		}
	}
	
} );

// form add site key
Vue.component( 'mx_recaptcha_site_key_form', {

	props: {
		site_key: {
			type: String,
			required: true
		}
	},
	template: `
		<form
			@submit.prevent="saveSiteKey"
			class="mx-iile-faq-form"
			:class="{mx_invalid_form: formInvalid}"
		>

			<div class="mx-form-saved"
				v-if="form_save_success"
			>
				${mxvjfepcdata_obj_admin.texts.form_saved}
			</div>

			<div class="mx-form-failed"
				v-if="form_failed"
			>
				${mxvjfepcdata_obj_admin.texts.form_failed}
			</div>
			
				
			<div>
				<input 
					type="text"
					v-model="v_site_key"
				/>
				<small
					v-if="!v_site_key"
					class="mx_email_empty">Enter a recaptcha site key</small>
			</div>

			<button
				type="submit"
				
			>Save</button>

		</form>
	`,
	data() {
		return {
			v_site_key: this.site_key,
			formInvalid: false,
			form_save_success: null,
			form_failed: null
		}
	},
	methods: {
		saveSiteKey() {

			if(
				this.v_site_key
			) {

				var _this = this;

				var data = {

					action: 'mx_changev_site_key',
					nonce: mxvjfepcdata_obj_admin.nonce,
					site_key: _this.v_site_key

				};

				jQuery.post( mxvjfepcdata_obj_admin.ajax_url, data, function( response ) {

					if( response === 'saved' ) {

						_this.form_save_success = true

						setTimeout( function() {

							_this.form_save_success = null

						}, 5000 )

					} else {

						_this.form_failed = true

						setTimeout( function() {

							_this.form_failed = null

						}, 5000 )

					}
				} );
			} else {
				this.formInvalid = true
			}
		}
	}
} );

if( document.getElementById( 'mx_admin_app' ) ) {

	var admin_app = new Vue( {
		el: '#mx_admin_app'
	} )

}