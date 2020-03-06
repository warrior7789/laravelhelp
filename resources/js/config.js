const apiDomain = Laravel.apiDomain;
const siteUrl = Laravel.siteUrl;
export const siteName = Laravel.siteName;

export const api = {
  apiDomain:apiDomain,
 //  searchskill: apiDomain + '/searchskill',
   anywheresearch: apiDomain + '/searchskill',
 //  allskill: apiDomain + '/allskill',
	// searchsp: siteUrl + '/searchsp',

  searchskill: 'api/searchskill',
  allskill: apiDomain + '/allskill', // change by bindiya
  searchsp:'/searchsp',
  favsp:'/favsp',
  //allskill:'/allskill',
};


export const language = {
	 en: {
    message: {
      hello: 'hello world'
    }
  },
  ja: {
    message: {
      hello: 'こんにちは、世界'
    }
  }
};