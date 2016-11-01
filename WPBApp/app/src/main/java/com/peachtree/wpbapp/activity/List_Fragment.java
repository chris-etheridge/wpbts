package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Entities.Clinic;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.Date;

import cz.msebera.android.httpclient.Header;

public class List_Fragment extends DialogFragment{

	private Activity parent;
	private int stackNum, type;
	private Context current_ctx;

	public static final int CLINIC = 1, EVENT = 2;

	private Events EVENTS_HELPER;

	public static List_Fragment init(int stackNum, int type){
		List_Fragment fragment = new List_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		args.putInt("type", type);
		fragment.setArguments(args);

		return fragment;
	}

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		parent = getActivity();
		stackNum = getArguments().getInt("stackNum");
		type = getArguments().getInt("type");

		current_ctx = this.getActivity();

		EVENTS_HELPER = new Events(current_ctx);
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		final View view = inflater.inflate(R.layout.event_list_layout, container, false);

		final ListView list = (ListView) view.findViewById(R.id.list);
		switch (type)
		{
			case EVENT:
				EVENTS_HELPER.GetAllEvents(new JsonHttpResponseHandler() {
					@Override
					public void onSuccess(int statusCode, Header[] headers, JSONArray a) {
						try {
							ArrayList es = Event.EventsFromJsonArray(a);

							list.setAdapter(new List_Adapter(es, parent, List_Adapter.Type.Event));
						} catch (JSONException e) {

						} catch (ParseException e) {
							e.printStackTrace();
						}
					}

					@Override
					public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
						// handle the error here
						int code = -1;

						try {
							if(response != null) {
								code = Integer.parseInt(response.getString("code"));
							} else {
								view.findViewById(R.id.list).setVisibility(View.GONE);
								view.findViewById(R.id.TXT_Error).setVisibility(View.VISIBLE);
							}
						} catch (JSONException e) {
							e.printStackTrace();
						}

						// parse the error
						String message = Networking.NetworkingErrors.GetErrorMessageForCode(code);

						// show to the user
						Toast.makeText(current_ctx, message, Toast.LENGTH_SHORT).show();
					}
				});

				break;
			case CLINIC:
				list.setAdapter(new List_Adapter(new ArrayList(), parent, List_Adapter.Type.Event));
				break;
		}

		view.findViewById(R.id.BTN_Search).setOnClickListener(new View.OnClickListener()
		{
			@Override
			public void onClick(View v)
			{
			}
		});

		return view;
	}
}
