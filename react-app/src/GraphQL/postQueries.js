import {gql} from '@apollo/client';

export const GET_POSTS = gql`
    {
        articlesGraphql {
            nodes {
                databaseId
                title
                excerpt
                link
                date
                featuredImage {
                    node {
                        mediaItemUrl
                    }
                }
                author {
                    node {
                        name
                    }
                }
                terms {
                    edges {
                        node {
                            name
                            slug
                            link
                        }
                    }
                }
            }
        }
    }
`;