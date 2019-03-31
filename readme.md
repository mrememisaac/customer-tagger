## My Thoughts

Thanks for the opportunity to try out for Senior Backend Developer. I have a few observations about the data model and the API.

While trying to set a reminder, we have to find a tag by name, only to pass just the id to the InfusionSoft helper, which in turn has to dig up both the contact and the tag before doing the taggin - seems kind of wasteful except that if these are two independent systems and we wish to conserve bandwith, then its OK, just my thoughts, I certainly have no idea of the design considerations that informed that decision

About the data model, why distinguish between user and contact? OK let's say contact filled our email subscription form whereas user signed up with us. Oh i get it, so contact data is available to our messaging system which is separate from our course management system, so our messaging system uses what it has i.e. contact->Email ( the difference in casing was interesting, seems to be a .net/MSSQL table naming style - I started as a .net developer) to ask for what it doesn't know - what alerts to fire

By thinking aloud I have answered my questions/addressed my concerns.



