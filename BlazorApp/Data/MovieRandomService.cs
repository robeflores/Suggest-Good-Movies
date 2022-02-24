namespace BlazorApp.Data;
public class MovieRandomService{
    public Movie GetMovie(){
        // get all 50 movies from results and store them in array

        // HASH TABLE
        // for first movie, get random number between 1 and 49 and use this index to retrieve from array. store in hash key value pair index and boolean
        // subsequent calls are incremented in order 
        // use hash map to determine if user already seen certain movie or not. if a true is reached, that means all 50 have been exhausted
        // once all 50 exhausted, get another 50 from website

        int startIndex = 1; // 1-9951 max start index
        // https://www.imdb.com/search/title/?title_type=feature&release_date=1990-01-01,2022-02-23&user_rating=6.0,&start=1&ref_=adv_nxt
        string url = "https://www.imdb.com/search/title/?title_type=feature&release_date=1990-01-01,2022-02-23&user_rating=6.0,&start="
            + startIndex + "&ref_=adv_nxt";

        HtmlAgilityPack.HtmlWeb web = new HtmlAgilityPack.HtmlWeb();
        HtmlAgilityPack.HtmlDocument doc = web.Load(url);
        foreach (var node in doc.DocumentNode.SelectNodes("//*[@class='lister-item-content']")){
            Console.WriteLine(node.Element("h3").SelectSingleNode("a").InnerText);
        }

        Movie m = new Movie("Resident Evil", "1996", "Horror, Mystery", "8.0", "finding themselves in a spooky mansion...");
        return m;
    }

        
}
