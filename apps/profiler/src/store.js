import Vue from 'vue'
import Vuex, { Store } from 'vuex'
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

Vue.use(Vuex)

export default new Store({
	state: {
		profiles: {},
	},
	mutations: {
		addProfile(state, { token, profile }) {
			Vue.set(state.profiles, token, profile)
		},
	},
	getters: {
		profile: (state) => (token) => {
			return state.profiles[token]
		},
	},
	actions: {
		loadProfile({ commit, state }, { token }) {
			if (state.profiles[token]) {
				return
			}
			axios.get(generateUrl('/apps/profiler/profile/{token}', { token }))
				.then((response) => {
					commit('addProfile', { token, profile: response.data.profile })
				})
		},
	},
})
