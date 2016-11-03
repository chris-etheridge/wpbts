package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.app.FragmentTransaction;
import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Build;
import android.os.Bundle;
import android.provider.CalendarContract;
import android.support.annotation.RequiresApi;
import android.util.Log;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Entities.Event;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;

public class Event_Info_Fragment extends DialogFragment {

    private Activity parent;
    private int id, array_index;
    private ArrayList<Event> events;
    private Event event;
    private float mCurrenty;

    private Context CURRENT_CONTEXT;

    private Events EVENTS_HELPER;

    public static Event_Info_Fragment init(int id) {
        Event_Info_Fragment fragment = new Event_Info_Fragment();

        Bundle args = new Bundle();
        args.putInt("id", id);
        fragment.setArguments(args);

        return fragment;
    }

    @RequiresApi(api = Build.VERSION_CODES.M)
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        parent = getActivity();

        id = getArguments().getInt("id");

        if (events != null) {
            int i = 0;
            while (i < events.size() && event == null) {
                if (events.get(i).getId() == id) {
                    event = events.get(i);
                    array_index = i;
                }
                i++;
            }
        }

        CURRENT_CONTEXT = parent;
        EVENTS_HELPER = new Events(parent);
    }

    @RequiresApi(api = Build.VERSION_CODES.M)
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        super.onCreateView(inflater, container, savedInstanceState);
        final View view = inflater.inflate(R.layout.event_info_layout, container, false);

        mCurrenty = view.getY();
        final float originalY = mCurrenty;


        if (event != null) {
            // get all of our fields
            TextView title = (TextView) view.findViewById(R.id.event_title);
            TextView desc = (TextView) view.findViewById(R.id.TXT_details);
            TextView date = (TextView) view.findViewById(R.id.TXT_date);
            TextView address = (TextView) view.findViewById(R.id.TXT_Address);

            ImageView image = (ImageView) view.findViewById(R.id.event_img);

            ProgressBar loaderView = (ProgressBar) view.findViewById(R.id.event_info_loader_view);

            Button going = (Button) view.findViewById(R.id.BTN_going);

            Button map = (Button) view.findViewById(R.id.BTN_map);

            ImageButton add = (ImageButton) view.findViewById(R.id.BTN_add);

            title.setText(event.getTitle());
            desc.setText(event.getDescription());
            date.setText("Date: " + event.getDateString(event.getDate()));
            address.setText("Address: " + event.getAddress());

            event.loadImage(parent.getString(R.string.API_BASE), image, loaderView);

            going.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if (event != null) {

                        // get our user id from shared preferences
                        String key = CURRENT_CONTEXT.getString(R.string.user_id_perference_key);
                        SharedPreferences prefs =
                                CURRENT_CONTEXT.getSharedPreferences(CURRENT_CONTEXT.getString(R.string.shared_preferences_key), Context.MODE_PRIVATE);

                        // get the value out
                        int id = prefs.getInt(key, 0);

                        EVENTS_HELPER.RSVPToEvent(event.getId(), id, 1, new JsonHttpResponseHandler() {
                            @Override
                            public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
                                boolean error = o.has("error");

                                // make sure our account is not null
                                if (error != true) {
                                    Toast.makeText(CURRENT_CONTEXT, "Successfully RSVP'ed to the event.", Toast.LENGTH_SHORT);
                                }
                                // else, there was an internal or network error
                                else {
                                    Networking.NetworkingErrors.GenericNetworkingErrorToast(CURRENT_CONTEXT, Toast.LENGTH_SHORT);
                                }

                                try {
                                    addEventToCalender(event);
                                } catch (ActivityNotFoundException e) {
                                    Toast.makeText(parent, "Could not add event.", Toast.LENGTH_SHORT).show();
                                }

                            }

                            @Override
                            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
                                // make sure response is not null, meaing we got something
                                if (response != null) {
                                    try {
                                        String msg = response.getString("message");

                                        Toast.makeText(CURRENT_CONTEXT, msg, Toast.LENGTH_SHORT).show();
                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }

                                }
                                // else, we could not connect at all
                                else {
                                    // show a generic networking error
                                    Networking.NetworkingErrors.GenericNetworkingErrorToast(CURRENT_CONTEXT, Toast.LENGTH_SHORT);
                                }
                            }
                        });
                    }
                }

            });

            add.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    addEventToCalender(event);
                }
            });
            map.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if (event != null) {
                        Event_Map_Fragment map = Event_Map_Fragment.init(1);
                        map.setEvents(events);
                        map.centerOn(array_index);
                        ((Home_Activity) parent).loadCenteredMap(map);
                        dismiss();
                    }
                }
            });
        } else {
            Toast.makeText(getActivity(), "Could not load event, please try again in a few moments.", Toast.LENGTH_SHORT);
            dismiss();
        }

        view.findViewById(R.id.pull_grip).setOnTouchListener(new View.OnTouchListener() {
            private float offset;
            private int threshold = (int) (getDialog().getWindow().getWindowManager().getDefaultDisplay().getHeight() * 2 / 3.0);

            @Override
            public boolean onTouch(View v, MotionEvent event) {
                int action = event.getAction();
                if (action == MotionEvent.ACTION_DOWN) {
                    offset = mCurrenty - event.getRawY();
                } else if (action == MotionEvent.ACTION_MOVE) {
                    mCurrenty = (int) (event.getRawY() + offset);
                    if (mCurrenty > originalY) {
                        view.setY(mCurrenty);
                    }
                } else if (action == MotionEvent.ACTION_UP) {

                    if (mCurrenty > originalY + threshold) {
                        dismiss();
                    } else {
                        mCurrenty = originalY;
                        view.setY(mCurrenty);
                    }
                }
                return true;
            }
        });

        view.findViewById(R.id.arrow_right).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                switch_event(1);
            }
        });

        view.findViewById(R.id.arrow_left).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                switch_event(-1);
            }
        });

        return view;
    }

    protected void switch_event(int direction) {

        int new_index = array_index + direction;
        if (new_index <= 0) {
            new_index = events.size() - 1;
        } else if (new_index == events.size()) {
            new_index = 0;
        }

        Event_Info_Fragment newFragment = Event_Info_Fragment.init(events.get(new_index).getId());
        newFragment.loadEvents(events);
        FragmentTransaction transaction = parent.getFragmentManager().beginTransaction();
        newFragment.show(transaction, "dialog");

        dismiss();
    }

    public void addEventToCalender(Event event) {
        Intent intent = new Intent(Intent.ACTION_EDIT);
        intent.setType("vnd.android.cursor.item/event");
        intent.putExtra(CalendarContract.EXTRA_EVENT_BEGIN_TIME, event.getDate());
        intent.putExtra(CalendarContract.EXTRA_EVENT_END_TIME, event.getDate());
        intent.putExtra(CalendarContract.EXTRA_EVENT_ALL_DAY, true);
        intent.putExtra(CalendarContract.Events.TITLE, event.getTitle());
        intent.putExtra(CalendarContract.Events.DESCRIPTION, event.getDescription());
        //intent.putExtra(CalendarContract.Events.EVENT_LOCATION, event.getAddress());
        startActivity(intent);
        Toast.makeText(parent, "Event Added To Calendar", Toast.LENGTH_SHORT);

    }

    @Override
    public void onStart() {
        super.onStart();
        WindowManager wm = (WindowManager) parent.getSystemService(Context.WINDOW_SERVICE);
        Display display = wm.getDefaultDisplay();
        getDialog().getWindow().setBackgroundDrawable(null);
        getDialog().getWindow().setLayout(display.getWidth() - 50, display.getHeight() - 50);

    }

    @Override
    public void onPause() {
        super.onPause();
        dismiss();
    }

    public void loadEvents(ArrayList<Event> ev) {
        events = ev;
    }
}
