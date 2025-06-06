// recaptcha
Vue.component('vue-recaptcha', VueRecaptcha)

// search
Vue.component('mx_faq_search', {

	props: {
		pageloading: {
			type: Boolean,
			required: true
		}
	},
	template: `
		<div class="mx-faq-search">

			<div v-if="!pageloading">
				<input
					type="text"
					placeholder="${mxvjfepcdata_obj_front.texts.find}"
					v-model="search"
					@input="mxSearch"
				/>
				<button @click.prevent="mxSearchClick" class="mx-faq-button">${mxvjfepcdata_obj_front.texts.search}</button>
			
				<div class="mx-make-question">
					<a 
						v-if="!pageloading"
						href="#mx-iile-question-form"
						class="mx-faq-button"
						@click.prevent="scrollToAskQuestion"
					>${mxvjfepcdata_obj_front.texts.make_question}</a>
				</div>

			</div>			 
		</div>
	`,
	data() {
		return {
			search: null,
			timeout: null
		}
	},
	methods: {
		scrollToAskQuestion() {

			jQuery('body,html').animate({
				scrollTop: jQuery('#mx-iile-question-form').offset().top - 130
			}, 800);

		},
		mxSearchClick() {

			var _this = this

			clearTimeout(_this.timeout)

			let search_query = this.search

			if (search_query) {

				_this.timeout = setTimeout(function () {

					_this.$emit('mx-search-request', search_query)

				}, 500)

			}

		},
		mxSearch() {

			var _this = this

			clearTimeout(_this.timeout)

			let search_query = this.search

			if (search_query) {

				if (search_query.length >= 3) {

					_this.timeout = setTimeout(function () {

						_this.$emit('mx-search-request', search_query)

					}, 1000)

				}

			}

			if (!search_query) {

				if (search_query !== null) {

					_this.timeout = setTimeout(function () {

						_this.$emit('mx-search-request', search_query)

					}, 1000)

				}

			}

		}
	}
})

// item
Vue.component('mx_faq_item', {

	props: {
		faqitemdata: {
			type: Object,
			required: true
		},
		item_index: {
			type: Number
		}
	},

	template: `
		<div class="mx-faq-item" :id="the_id">
			<div class="mx-faq-item-header">
				<div class="mx-faq-item-date">
					{{ the_date }}
				</div>
				<div class="mx-faq-item-subject">
					<a 
						@click.prevent="toggleQuestion"
						href="#"
					>
						<strong>{{ the_title }}</strong>
						<span 
							class="dashicons-plus dashicons"
							:style="{display:[item_index === 0 ? 'none' : '']}"
						></span>
						<span
							class="dashicons-minus dashicons dashicons"
							:style="{display:[item_index !== 0 ? 'none' : '']}"
						></span>
					</a>
					
				</div>
				<div class="mx-faq-item-user">
					{{ the_user_name }}
				</div>
			</div>

			<div class="mx-faq-item-body" :style="{display:[item_index !== 0 ? 'none' : '']}">
				<div class="mx-faq-item-question" v-html="the_question"></div>
				<div class="mx-faq-item-answer" v-html="the_answer"></div>
			</div>
		</div>
	`,
	data() {
		return {

		}
	},
	methods: {
		toggleQuestion() {

			jQuery('#' + this.the_id).find('.mx-faq-item-body').slideToggle('fast');
			jQuery('#' + this.the_id).find('.dashicons-plus').toggle();
			jQuery('#' + this.the_id).find('.dashicons-minus').toggle();


		}
	},
	computed: {
		the_id() {
			return this.faqitemdata.ID
		},
		the_title() {
			return this.faqitemdata.post_title
		},
		the_question() {

			// line break
			var content = this.faqitemdata.post_content

			content = content.replace(/\r?\n/g, '<br>')

			return content
		},
		the_answer() {

			var answer = this.faqitemdata.answer

			answer = answer.replace(/\r?\n/g, '<br>')

			return answer
		},
		the_user_name() {
			return this.faqitemdata.user_name
		},
		the_date() {
			let date = new Date(this.faqitemdata.post_date)

			let day = date.getDate()

			let month = date.getMonth() + 1

			let year = date.getFullYear()

			return day + '/' + month + '/' + year
		},
	}
})

// list of items
Vue.component('mx_faq_list_items', {

	props: {
		getfaqitems: {
			type: Array,
			required: true
		},
		parsejsonerror: {
			type: Boolean,
			required: true
		},
		pageloading: {
			type: Boolean,
			required: true
		},
		load_img: {
			type: String,
			required: true
		},
		no_items: {
			type: String,
			required: true
		},
	},
	template: `
		<div class="mx-faq-list-of-items">

			<div v-if="parsejsonerror">
				${mxvjfepcdata_obj_front.texts.error_getting}
			</div>
			<div v-else>

				<div v-if="!getfaqitems.length">				

					<div v-if="pageloading" class="mx-loading-faq">
						<img :src="load_img" alt="" class="" />						
					</div>
					<div v-else class="mx-no-items-found">
						{{ no_items }}
					</div>

				</div>
				<div v-else>

					<mx_faq_item
						v-for="(item, index) in get_items"
						:item_index="index"
						:key="item.ID"				
						:faqitemdata="item"
					></mx_faq_item>

				</div>

			</div>				
			
		</div>
	`,
	data() {
		return {
		}
	},
	computed: {
		get_items() {
			return this.getfaqitems
		}
	}

})

// faq pagination
Vue.component('mx_faq_pagination', {

	props: {
		faqcount: {
			type: Number,
			required: true
		},
		faqperpage: {
			type: Number,
			required: true
		},
		faqcurrentpage: {
			type: Number,
			required: true
		},
		pageloading: {
			type: Boolean,
			required: true
		}
	},

	template: `
		<div v-if="!pageloading && ( faqcount - faqperpage ) > 0">

			<ul class="mx-faq-pagination">		

				<li
					v-for="page in coutPages"
					:key="page"
					:class="[page === faqcurrentpage ? 'mx-current-page' : '']"
				><a 
					:href="'#page-' + page"
					@click.prevent="getPage(page)"
					>{{ page }}</a></li>

			</ul>

		</div>
	`,
	methods: {
		getPage(page) {

			this.$emit('get-faq-page', page)

			jQuery('body,html').animate({
				scrollTop: jQuery('.mx-faq-search').offset().top - 130
			}, 800);

		}
	},
	computed: {
		coutPages() {

			let difference = this.faqcount / this.faqperpage

			if (Number.isInteger(difference)) {
				return difference
			}

			return parseInt(difference) + 1
		}
	}
})

// form
Vue.component('mx_faq_form',
	{
		template: `
			<div class="mx-iile-faq-form-wrap" id="mx-iile-question-form">
				<div class="mx-form-title">
	                <span>${mxvjfepcdata_obj_front.texts.call_to_question}</span>
	            </div>

	            <form
					@submit.prevent="onSubmit"
					class="mx-iile-faq-form"
					:class="[
						invalidForm ? 'mx_invalid_form' : '',
						messageSending ? 'mx_message_sending' : '',
						messageHasSent ? 'mx-message-has-sent' : ''
					]" 
				>
					<div class="mx-two-inputs-row">
						<div class="mx-form-control">
							<input
								type="text"
								placeholder="${mxvjfepcdata_obj_front.texts.p_your_name}"
								v-model="user_name"
								:class="{mx_empty_field: !user_name}"
							/>
							<small>${mxvjfepcdata_obj_front.texts.your_name}</small>
						</div>

						<div class="mx-form-control">
							<input
								type="email"
								placeholder="${mxvjfepcdata_obj_front.texts.p_your_email}"
								v-model="user_email"
								:class="[!user_email ? 'mx_empty_field' : '', !validateEmail( user_email ) ? 'mx_incorrect_email' : '']"
							/>
							<small>${mxvjfepcdata_obj_front.texts.your_email}</small>
							<small class="mx_small_inv_email">${mxvjfepcdata_obj_front.texts.your_email_failed}</small>
						</div>
					</div>

					<div class="mx-form-control">
						<input
							type="text"
							placeholder="${mxvjfepcdata_obj_front.texts.subject}"
							v-model="subject"
							:class="{mx_empty_field: !subject}"
						/>
						<small>${mxvjfepcdata_obj_front.texts.enter_subject}</small>
					</div>

					<div class="mx-form-control">
						<input
							type="checkbox"
							id="mx_agrement"
							v-model="agrement"
							:class="{mx_empty_field: !agrement}"
						/>
						<label for="mx_agrement">
							${mxvjfepcdata_obj_front.texts.agre_text} <a href="${mxvjfepcdata_obj_front.texts.agre_link}" target="_blank">${mxvjfepcdata_obj_front.texts.agre_doc_name}</a>
						</label>
						<small>${mxvjfepcdata_obj_front.texts.agre_failed}</small>
					</div>

					<div class="mx-form-control"> 
						<textarea
							cols="30" rows="10"
							placeholder="${mxvjfepcdata_obj_front.texts.your_message}"
							v-model="message"
							:class="{mx_empty_field: !message}"
						></textarea>
						<small>${mxvjfepcdata_obj_front.texts.your_message_failed}</small>
					</div>

					<div class="mx-recaptcha-wrap">
						<vue-recaptcha sitekey="${mxvjfepcdata_obj_front.site_key}"
							@verify="getRecaptchaVerify"
							@expired="getRecaptchaExpired"
							:class="{mx_empty_field: !re_captcha}"></vue-recaptcha>
						<small>${mxvjfepcdata_obj_front.texts.recaptcha_failed}</small>
					</div>
				
					<div class="mx-send-message">
						<img :src="load_img" alt="" class="mx-sending-progress" />
						<button>${mxvjfepcdata_obj_front.texts.submit}</button>
					</div>
					
					<div class="mx-thank-you-for-message">
						<span>${mxvjfepcdata_obj_front.texts.success_sent}</span>
					</div>

				</form>
			</div>
		`,
		data() {
			return {
				user_name: null,
				user_email: null,
				agrement: false,
				subject: null,
				message: null,
				invalidForm: false,
				load_img: mxvjfepcdata_obj_front.loading_img,
				messageSending: false,
				messageHasSent: false
				, re_captcha: null
			}
		},
		methods: {
			getRecaptchaVerify(response) {

				this.re_captcha = response

			},
			getRecaptchaExpired() {

				this.re_captcha = null

				console.log('expired')

			},
			onSubmit() {

				if (!this.messageHasSent) {

					this.messageSending = true

					if (
						this.user_name &&
						this.user_email &&
						this.agrement &&
						this.subject &&
						this.message
						&& this.re_captcha
					) {

						// post
						var _this = this;

						var data = {

							action: 'mx_faq_iile',
							nonce: mxvjfepcdata_obj_front.nonce,

							user_name: _this.user_name,
							user_email: _this.user_email,
							subject: _this.subject,
							message: _this.message
						};

						jQuery.post(mxvjfepcdata_obj_front.ajax_url, data, function (response) {

							_this.sentDataReaction(response);

						});

					} else {

						this.invalidForm = true

						this.messageSending = false

					}
					this.validateEmail(this.user_email)

				}

			},
			validateEmail(email) {

				// let patern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

				return String(email).toLowerCase().match(
					/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
				);

			},
			sentDataReaction(response) {

				if (response === 'integer') {

					this.user_name = null
					this.user_email = null
					this.agrement = false
					this.subject = null
					this.message = null

					this.messageHasSent = true

					this.messageSending = false

					this.invalidForm = false

				} else {

					this.messageSending = false

				}

			}

		}
	}
)

if (document.getElementById('mx_iile_faq')) {

	var app = new Vue({
		el: '#mx_iile_faq',
		data: {
			noItemsMessages: {
				noItemsInDB: mxvjfepcdata_obj_front.texts.no_questions,
				noSearchItems: mxvjfepcdata_obj_front.texts.nothing_found
			},
			noItemsDisplay: '',
			faqCurrentPage: 1,
			faqPerPage: 6,
			faqCount: 0,
			faqItems: [],
			parseJSONerror: false,
			pageLoading: true,
			loadImg: mxvjfepcdata_obj_front.loading_img,
			query: ''
		},
		methods: {
			searchQuestion(query) {

				this.noItemsDisplay = this.noItemsMessages.noSearchItems

				// clear data ...
				this.faqItems = []

				this.pageLoading = true

				let page = 1

				this.faqCurrentPage = page

				this.faqCurrentPage = page

				history.pushState({ faqPage: page }, "", '#page-' + page)
				// ... clear data

				// set query
				let _query = ''

				if (query !== null) {

					_query = query

				}

				this.query = _query

				var _this = this

				var data = {

					action: 'mx_search_faq_items',
					nonce: mxvjfepcdata_obj_front.nonce,
					current_page: _this.faqCurrentPage,
					faq_per_page: _this.faqPerPage,
					query: query
				};

				jQuery.post(mxvjfepcdata_obj_front.ajax_url, data, function (response) {

					if (_this.isJSON(response)) {

						_this.get_count_faq_items(query)

						_this.faqItems = JSON.parse(response);

						_this.pageLoading = false

					} else {

						this.parseJSONerror = true

					}

				});

			},
			changeFaqPage(page) {

				this.faqCurrentPage = page

				history.pushState({ faqPage: page }, "", '#page-' + page)

				this.get_faq_items()
			},
			get_current_page() {

				let curretn_page = window.location.href

				if (curretn_page.indexOf('#page-') >= 0) {

					let matches = curretn_page.match(/#page-(\d+)/)

					let get_page = parseInt(matches[1]);

					if (Number.isInteger(get_page)) {

						this.faqCurrentPage = get_page

					}

				} else {

					history.pushState({ faqPage: '1' }, "", '#page-1')

				}

			},
			get_count_faq_items(query) {

				let _query = ''

				if (query !== null) _query = query

				var _this = this

				var data = {

					action: 'mx_get_count_faq_items',
					nonce: mxvjfepcdata_obj_front.nonce,
					query: _query
				};

				jQuery.post(mxvjfepcdata_obj_front.ajax_url, data, function (response) {

					let count = parseInt(response)

					if (Number.isInteger(count)) {
						_this.faqCount = count
					}

				});

			},
			get_faq_items() {

				this.noItemsDisplay = this.noItemsMessages.noItemsInDB

				var _this = this

				var data = {

					action: 'mx_get_faq_items',
					nonce: mxvjfepcdata_obj_front.nonce,
					current_page: _this.faqCurrentPage,
					faq_per_page: _this.faqPerPage,
					query: _this.query
				};

				jQuery.post(mxvjfepcdata_obj_front.ajax_url, data, function (response) {

					if (_this.isJSON(response)) {

						var result = JSON.parse(response);

						_this.faqItems = result;

						_this.pageLoading = false

					} else {

						this.parseJSONerror = true

					}

				});

			},
			isJSON(str) {
				try {
					JSON.parse(str);
				} catch (e) {
					return false;
				}
				return true;
			}
		},
		beforeMount() {

			// get current page
			this.get_current_page()

			// get count of faq items
			this.get_count_faq_items(null)

			// get faq items
			this.get_faq_items()
		}
	})

}

// 
jQuery(document).ready(function ($) {
	$('.mx-faq-item-header').on('click', function (e) {
		e.preventDefault();

		const $item = $(this).closest('.mx-faq-item');
		const $body = $item.find('.mx-faq-item-body');
		const $plus = $item.find('.dashicons-plus');
		const $minus = $item.find('.dashicons-minus');

		$body.stop(true, true).slideToggle(200);
		$plus.toggle();
		$minus.toggle();
	});
});