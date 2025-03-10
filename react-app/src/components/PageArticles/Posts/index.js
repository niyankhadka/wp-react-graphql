import React, { useEffect, useState } from "react";
import {useQuery, gql} from "@apollo/client";
import {GET_POSTS} from "../../../GraphQL/postQueries";

const Articles = () => {
    const {data, loading, error} = useQuery(GET_POSTS);

    useEffect(() => {
        if (error) {
            console.log(error);
        }
    }, [error]);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :</p>;

    return (
        <div>
            <h1>List of Articles</h1>
            {data &&
            data.articlesGraphql.nodes.map((post) => (
                <div key={post.databaseId}>
                    <h2><a href={post.link}>{post.title}</a></h2>
                    <img src={post.featuredImage.node.mediaItemUrl} alt={post.title}/>
                    <p>{post.excerpt}</p>
                    <p>{post.date}</p>
                    <p>{post.author.node.name}</p>
                    <ul>
                        {post.terms.edges.map((term) => (
                            <li key={term.node.slug}><a href={term.node.link}>{term.node.name}</a></li>
                        ))}
                    </ul>
                </div>
            ))}
        </div>
    );
}

export default Articles;