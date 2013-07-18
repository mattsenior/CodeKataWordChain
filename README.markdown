# Word Chain CodeKata

## Requirements

-   A Neo4j server running on the default `localhost:7474`.
-   A couple of hours to add the relationships to the graph.

## CodeKata Instructions

>   Write a program that solves word-chain puzzles.
>   
>   There’s a type of puzzle where the challenge is to build a chain of words, starting with one particular word and ending with another. Successive entries in the chain must all be real words, and each can differ from the previous word by just one letter. For example, you can get from "cat" to "dog" using the following chain.
>   
>   cat
>   cot
>   cog
>   dog
>   
>   The objective of this kata is to write a program that accepts start and end words and, using words from the dictionary, builds a word chain between them. For added programming fun, return the shortest word chain that solves each puzzle. For example, my Powerbook running Ruby can turn "lead" into "gold" in four steps (lead, load, goad, gold).
>   
>   On the final pairing, assuming that the problem is completed, to optimise the program to perform the task as quickly as possible. 
