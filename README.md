# wp-react-graphql

This is the sample WordPress Based plugin which use React Js and Wp GraphQL to query data from the custom post type.

Currently, it is still in development phase but basic process and query is completed to understand the use of React Js and WP GraphQL.

To install it, 
Go to WordPress -> Plugins -> Upload Plugin 

Upload the donwnloaded file from this repository.

Another way is to git clone this repository to the plugins folder. 

You need to install 'WP GraphQL' plugin from WordPress before activating this plugin.

Once you have activated, you will see 'Articles' as custom post type and
it's slug is '/articles/' with single article slug as '/article/post-slug-here'.

To use the slug 'articles', create a page name with any title but make sure to have slug saved with 'articles'.

It also has archive link set as 'article-category' registered under 'article_category' as taxonomy.

Now, you can create the content and view the basic info by using the WordPress with React Js and WP GraphQL.

Note: This is not completed and can work upto 'Articles' page and rest of the single pages will do show same content as shown in articles page.

If you need to build the project, just go over to: react-app folder and you can use npm run build to build or npm install to install all the packages. 