<template>
	<header class="top-bar" :class="background">
		<h2 class="url">
			{{ profile.url }}
		</h2>
		<div>
			<div><b>Method:</b> {{ profile.method }} </div>
			<div><b>HTTP Status:</b> {{ profile.status_code }} </div>
			<div><b>Profiled on:</b> {{ time }} </div>
			<div><b>Token:</b> {{ profile.token }}</div>
		</div>
	</header>
</template>

<script>
export default {
	name: 'ProfileHeader',
	props: {
		profile: {
			type: Object,
			required: true,
		},
	},
	computed: {
		background() {
			if (this.profile.status_code === '200') {
				return 'status-success'
			}
			if (this.profile.status_code === '500') {
				return 'status-error'
			}
			return 'status-warning'
		},
		time() {
			return new Date(Date.UTC(this.profile.time)).toUTCString()
		},
	},
}
</script>

<style lang="scss" scoped>
.top-bar {
	right: 12px;
	display: flex;
	z-index: 10;
	flex-direction: column;
	padding: 8px;
	border-bottom: 1px solid var(--color-border);
	& > div {
		display: flex;
		flex-direction: row;
		& > div {
			margin-left: 20px;
		}
	}
}
.status-success {
	background-color: rgba(112, 196, 137, 0.75);
}
.status-error {
	background-color: rgba(231, 55, 51, 0.65);
}
.status-warning {
	background-color: rgba(213, 118, 41, 0.75);
}

.url {
	margin-left: 48px;
}

</style>
