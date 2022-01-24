<template>
	<div v-if="http">
		<h2>Request</h2>
		<h3>Cookies</h3>
		<div v-for="(key, cookie) in http.request.cookies" :key="key">
			<b>{{ key }}:</b>
			{{ cookie }}
		</div>
		<h2>Response</h2>
	</div>
	<div v-else>
		Loading
	</div>
</template>

<script>
import { mapState } from 'vuex'

export default {
	name: 'RequestView',
	computed: {
		http() {
			return this.profiles[this.$route.params.token]?.collectors.http
		},
		...mapState(['profiles']),
	},
}
</script>
