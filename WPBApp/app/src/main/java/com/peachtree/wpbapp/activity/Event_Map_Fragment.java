package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.app.FragmentTransaction;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.R;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Locale;

public class Event_Map_Fragment extends DialogFragment implements OnMapReadyCallback, GoogleMap.OnMarkerClickListener
{

	private Activity parent;
	private int stackNum, index = -1;
	private MapFragment mapFragment;
	private GoogleMap mMap;
	private View mView;

	@Override
	public boolean onMarkerClick(Marker marker) {

		index = (int)marker.getTag();

		((TextView)mView.findViewById(R.id.TXT_description)).setText(generateDescription(events.get(index)));

		return true;
	}

	private ArrayList<Event> events;

	@Override
	public void onMapReady(GoogleMap googleMap)
	{
		mMap = googleMap;
	}

	public static Event_Map_Fragment init(int stackNum){
		Event_Map_Fragment fragment = new Event_Map_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		fragment.setArguments(args);

		return fragment;
	}

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		parent = getActivity();
		stackNum = getArguments().getInt("stackNum");

		mapFragment = new MapFragment();
    }

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		super.onCreateView(inflater, container, savedInstanceState);
		final View view = inflater.inflate(R.layout.event_map_layout, container, false);

		FragmentTransaction transaction = getChildFragmentManager().beginTransaction();
		transaction.add(R.id.map_layout, mapFragment, "map").commit();
		mapFragment.getMapAsync(this);

		loadEventsToMap();

		view.findViewById(R.id.BTN_directions).setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				String uri = String.format(Locale.ENGLISH, "geo:%f,%f", events.get(index).getLat(), events.get(index).getLng());
				Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(uri));
				parent.startActivity(intent);
			}
		});

		mView = view;
		return view;
	}

	public void setEvents(ArrayList<Event> e){
		events = e;
	}

	private void loadEventsToMap(){
		for (int i = 0; i < events.size(); i++)
		{
			Event e = events.get(i);
			LatLng co_ord = new LatLng(e.getLat(),e.getLng());
			MarkerOptions mOpt = new MarkerOptions().position(co_ord).title(e.getTitle()).draggable(false);
			Marker marker = mMap.addMarker(mOpt);

			marker.setTag(i);
		}
	}

	private String generateDescription(Event event){
		SimpleDateFormat dayFormat = new SimpleDateFormat("EEEE dd");
		String output = String.format("%s\n%s\n%s\n%s", event.getTitle(), event.getAddress(), event.getType(), dayFormat.format(event.getDate()));
		return output;
	}
}
