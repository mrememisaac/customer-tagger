## My Thoughts

Thanks for the opportunity to try out for Senior Backend Developer. I have a few observations about the data model and the API.

While trying to set a reminder, we have to find a tag by name, only to pass just the id to the InfusionSoft helper, which in turn has to dig up both the contact and the tag before doing the tagging - seems kind of wasteful except that if these are two independent systems and we wish to conserve bandwith, then its OK, just my thoughts, I certainly have no idea what the design considerations are, that informed this approach

About the data model, why distinguish between user and contact? OK let's say contact filled our email subscription form whereas user signed up with us. Oh I get it, so contact data is available to our messaging system which is separate from our course management system. So our messaging system uses what it has i.e. contact->Email (the difference in speling of email between contact and user was interesting, seems to be a .net/MSSQL table naming style - I started as a .net developer) to ask for what it doesn't know i.e. what alerts to fire

By thinking aloud I guess I have answered my questions/addressed my concerns.



