package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.app.FragmentTransaction;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.MapFragment;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.R;

import java.util.ArrayList;

public class Event_Map_Fragment extends DialogFragment implements OnMapReadyCallback
{

	private Activity parent;
	private FragmentActivity mContext;
	private int stackNum;
	private MapFragment mapFragment;
	private GoogleMap mMap;
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

		return view;
	}

	@Override
	public void onAttach(Activity activity){
		mContext = (FragmentActivity) activity;
		super.onAttach(activity);
	}

	public void loadEvents(ArrayList<Event> e){
		events = e;
	}

	private void loadEventsToMap(){
		for (Event e:events)
		{
			
		}
	}
}
