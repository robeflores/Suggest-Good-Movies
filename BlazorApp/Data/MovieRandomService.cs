namespace BlazorApp.Data;
public class MovieRandomService {
    public List<Movie>? movies;

    public MovieRandomService()
    {
        movies = new List<Movie>();
    }

    public Movie GetMovie() {
        if (movies.Count == 0)
            ScrapeMovies();
        Random rnd = new Random();
        return movies[ rnd.Next(movies.Count) ];
    }

    public void ScrapeMovies() {
        Random rnd = new Random();
        int startIndex = 1 + rnd.Next(9950); // 1-9951 max start index
        // https://www.imdb.com/search/title/?title_type=feature&release_date=1990-01-01,2022-02-23&user_rating=6.0,&start=1&ref_=adv_nxt
        string url = "https://www.imdb.com/search/title/?title_type=feature&release_date=1990-01-01,2022-02-23&user_rating=6.0,&start="
            + startIndex + "&ref_=adv_nxt";

        HtmlAgilityPack.HtmlWeb web = new HtmlAgilityPack.HtmlWeb();
        HtmlAgilityPack.HtmlDocument doc = web.Load(url);
        movies = new List<Movie>();
        foreach (var node in doc.DocumentNode.SelectNodes("//div[@class='lister-item-content']"))
        {
            string title = node.Element("h3").SelectSingleNode("a").InnerText;
            string year = node.Element("h3").SelectNodes("span").Last().InnerText;
            year = year.Replace("(", "").Replace(")", "").Replace("I", "").Replace(" ", "");
            string genres = node.Descendants("span").Where(span => span.HasClass("genre")).First().InnerText;
            genres = genres.Replace("\n", "");
            string rating = node.Descendants("div").Where(div => div.HasClass("ratings-imdb-rating")).First().InnerText;
            rating = rating.Replace("\n", "");
            rating = rating.Replace(" ", "");
            string description = node.Descendants("p").Where(p => p.HasClass("text-muted")).Last().InnerText;
            description = description.Replace("\n", "");
            string link = "https://www.imdb.com" + node.Element("h3").SelectSingleNode("a").GetAttributeValue("href", string.Empty);
            link = link.Replace("?ref_=adv_li_tt", "");

            movies.Add(new Movie(title, year, genres, rating, description, link));
        }
    }


}
