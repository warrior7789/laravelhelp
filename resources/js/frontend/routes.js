
import search from './components/search.vue';
import home from './components/homesearch.vue';
import messages from './components/messages.vue';



export default [
	{
		path: '/',
		name: 'index',
		component: home,
		meta: {}
	},
	
	{ 	path: '/search', 
		component: search, 
		name : 'search'
	},
	
	{ 	path: '/messages', 
		component: messages, 
		name : 'messages'
	}
];