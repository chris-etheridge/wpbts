package com.peachtree.wpbapp.layout_Handlers;

import android.content.Context;
import android.util.Xml;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseExpandableListAdapter;
import android.widget.TextView;
import android.widget.Toast;

import com.peachtree.wpbapp.R;

import org.xmlpull.v1.XmlPullParser;
import org.xmlpull.v1.XmlPullParserException;

import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Tyron on 9/21/2016.
 */
public class Accordion_Handler extends BaseExpandableListAdapter
{
	private Context ctx;
	private int src_file;
	private List items;

	public Accordion_Handler(Context ctx, int src_file)
	{
		this.ctx = ctx;
		this.src_file = src_file;
		try
		{
			items = parseXML();
		} catch (IOException e)
		{
			Toast.makeText(ctx, e.toString(),
					Toast.LENGTH_SHORT).show();
		} catch (XmlPullParserException ex)
		{
			Toast.makeText(ctx, ex.toString(),
					Toast.LENGTH_SHORT).show();
		}


	}

	@Override
	public int getGroupCount()
	{
		return items.size();
	}

	@Override
	public int getChildrenCount(int i)
	{
		return 1;
	}

	@Override
	public Object getGroup(int i)
	{
		return ((String[]) items.get(i))[0];
	}

	@Override
	public Object getChild(int i, int i1)
	{
		return ((String[]) items.get(i))[1];
	}

	@Override
	public long getGroupId(int i)
	{
		return i;
	}

	@Override
	public long getChildId(int i, int i1)
	{
		return i1;
	}

	@Override
	public boolean hasStableIds()
	{
		return false;
	}

	@Override
	public View getGroupView(int i, boolean b, View view, ViewGroup viewGroup)
	{
		String headerTitle = (String) getGroup(i);
		if (view == null)
		{
			LayoutInflater inflater = (LayoutInflater) ctx.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			view = inflater.inflate(R.layout.list_group, null);
		}
		view.setTag("Group_"+i);
		((TextView) view.findViewById(R.id.lblGroupTitle)).setText(headerTitle);

		return view;
	}

	@Override
	public View getChildView(int i, int i1, boolean b, View view, ViewGroup viewGroup)
	{
		String content = (String)getChild(i, i1);
		if (view == null)
		{
			LayoutInflater layoutInflater = (LayoutInflater) ctx.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			view = layoutInflater.inflate(R.layout.list_item, null);
		}
		((TextView) view.findViewById(R.id.lbl_itemcontent)).setText(content);

		return view;
	}

	@Override
	public boolean isChildSelectable(int i, int i1)
	{
		return false;
	}

	public List parseXML() throws XmlPullParserException, IOException
	{
		InputStream in = ctx.getResources().openRawResource(src_file);
		try
		{
			XmlPullParser parser = Xml.newPullParser();
			parser.setFeature(XmlPullParser.FEATURE_PROCESS_NAMESPACES, false);
			parser.setInput(in, null);
			parser.nextTag();
			return readFeed(parser);
		}catch(Exception e){
			Toast.makeText(ctx, e.toString(),
					Toast.LENGTH_SHORT).show();
			return null;
		}
		finally
		{
			in.close();
		}
	}

	private List readFeed(XmlPullParser parser) throws XmlPullParserException, IOException
	{
		List entries = new ArrayList();

		parser.require(XmlPullParser.START_TAG, null, "startList");
		while (parser.next() != XmlPullParser.END_TAG)
		{
			if (parser.getEventType() != XmlPullParser.START_TAG)
			{
				continue;
			}
			String name = parser.getName();
			if (name.equals("item"))
			{
				entries.add(readEntry(parser));
			} else
			{
				skip(parser);
			}
		}

		return entries;
	}

	private String[] readEntry(XmlPullParser parser) throws XmlPullParserException, IOException
	{
		parser.require(XmlPullParser.START_TAG, null, "item");
		String[] result = new String[2];
		while (parser.next() != XmlPullParser.END_TAG)
		{
			if (parser.getEventType() != XmlPullParser.START_TAG)
			{
				continue;
			}
			String name = parser.getName();
			if (name.equals("title"))
			{
				result[0] = readItem("title", parser);
			} else if (name.equals("content"))
			{
				result[1] = readItem("content", parser);
			} else
			{
				skip(parser);
			}
		}

		return result;
	}

	private String readItem(String itemType, XmlPullParser parser) throws XmlPullParserException, IOException
	{
		parser.require(XmlPullParser.START_TAG, null, itemType);
		String result = "";
		if (parser.next() == XmlPullParser.TEXT)
		{
			result = parser.getText();
			parser.nextTag();
		}
		parser.require(XmlPullParser.END_TAG, null, itemType);
		return result;
	}

	private void skip(XmlPullParser parser) throws XmlPullParserException, IOException
	{
		if (parser.getEventType() != XmlPullParser.START_TAG)
		{
			throw new IllegalStateException();
		}
		int depth = 1;
		while (depth != 0)
		{
			switch (parser.next())
			{
				case XmlPullParser.END_TAG:
					depth--;
					break;
				case XmlPullParser.START_TAG:
					depth++;
					break;
			}
		}
	}


}
