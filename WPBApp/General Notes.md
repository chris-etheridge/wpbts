# Notes

### General

- `method_name_q` means that the method is a question, and will return a boolean. 
  - e.g `is_user_logged_in_q` 


### Using Networking classes

Example code for `AsycnHttpResponseHandler` methods is below.

- Each class constructor takes a URL that is the API endpoint for this class
  - e.g. `events` class would take `/api/events`
- Each method in the class has an optional `AsnycHttpResponseHandler`, which can use, if you want fine grained control during the life cycle of the response.



```java
import org.json.*;
import com.loopj.android.http.*;

class TwitterRestClientUsage {
    public void getPublicTimeline() throws JSONException {
        TwitterRestClient.get("statuses/public_timeline.json", null, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                // If the response is JSONObject instead of expected JSONArray
            }
            
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONArray timeline) {
                // Pull out the first event on the public timeline
                JSONObject firstEvent = timeline.get(0);
                String tweetText = firstEvent.getString("text");

                // Do something with the response
                System.out.println(tweetText);
            }
        });
    }
}
```