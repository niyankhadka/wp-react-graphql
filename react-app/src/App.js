import React from "react";
import {
    ApolloClient,
    InMemoryCache,
    ApolloProvider,
    useQuery,
    gql,
    HttpLink
} from "@apollo/client";
import {onError} from "@apollo/client/link/error";
import logo from "./logo.svg";
import "./App.css";
import Articles from "./components/PageArticles/Posts";
import Posts from "./components/SingleArticles/Posts";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom"; 

const client = new ApolloClient({
    link: new HttpLink({uri: articlesGraphqlReactApp.apiUrl}),
    cache: new InMemoryCache(),
});

const routeURL = articlesGraphqlReactApp.siteUrl + "/articles/";

function App() {
    return (
        <Router>
            <ApolloProvider client={client}>
                    <Articles/>
                    <Routes>
                        <Route path={routeURL} element={<p>Single Article</p>}/>
                    </Routes>
            </ApolloProvider>
        </Router>
    );
}

export default App;
