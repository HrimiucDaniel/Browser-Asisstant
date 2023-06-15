from googlesearch import search

query = "when did Demon Slayer started"
num_results = 5
for url in search(query):
    print(url)
    num_results -= 1
    if num_results == 0:
        break